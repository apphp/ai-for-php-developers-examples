<?php

use function Codewithkyrian\Transformers\Pipelines\pipeline;

final class SemanticEventSearch
{
    private string $model = 'Xenova/paraphrase-multilingual-MiniLM-L12-v2';
    private string $cachePath;
    private string $defaultQuery = 'санкции против IT-компаний';
    private int $topN;

    private ?string $query = null;

    /** @var list<array{id:int,title:string,description:string}> */
    private array $events;

    /** @var array<int, list<float|int>> */
    private array $eventEmbeddingsById = [];

    private $embedder;

    /**
     * Create a new semantic search instance.
     *
     * @param int $topN Number of results to return.
     * @param string $cachePath Path to the cache file.
     */
    public function __construct(int $topN = 3, string $cachePath = '')
    {
        $this->cachePath = $cachePath;;
        $this->events = [];
        $this->embedder = null;
        $this->topN = $topN;
    }

    /**
     * Inject events that will be indexed/searched.
     *
     * @param list<array{id:int,title:string,description:string}> $events
     * @return $this
     */
    public function setEvents(array $events): self
    {
        $this->events = $events;
        $this->eventEmbeddingsById = [];
        return $this;
    }

    /**
     * Set the embeddings model identifier.
     *
     * Switching model invalidates in-memory embeddings.
     *
     * @param string $model
     * @return $this
     */
    public function setModel(string $model): self
    {
        $this->model = $model;
        $this->embedder = null;
        $this->eventEmbeddingsById = [];
        return $this;
    }

    /**
     * Set the query to be searched.
     *
     * @param string $query
     * @return $this
     */
    public function setQuery(string $query): self
    {
        $q = trim($query);
        $this->query = $q === '' ? null : $q;
        return $this;
    }

    /**
     * Run the end-to-end semantic search pipeline (cache -> embed query -> score -> top-N).
     *
     * @return array{query:string,results:list<array{score:float,event:array{id:int,title:string,description:string}}>}
     * @throws RuntimeException If events are not set or embeddings output is unexpected.
     */
    public function run(): array
    {
        if (count($this->events) === 0) {
            throw new RuntimeException('Events list is empty. Call setEvents() before run().');
        }

        if ($this->embedder === null) {
            $this->embedder = pipeline('embeddings', $this->model);
        }

        $this->loadEmbeddingsFromCacheIfCompatible();
        $this->ensureAllEventEmbeddings();

        $query = $this->query ?? $this->defaultQuery;
        $queryVec = $this->embedText($query);

        $results = $this->search($queryVec);
        return [
            'query' => $query,
            'results' => $results,
        ];
    }

    /**
     * Compute an embedding vector for a single text.
     *
     * @param string $text
     * @return list<float|int>
     * @throws RuntimeException
     */
    private function embedText(string $text): array
    {
        $emb = ($this->embedder)($text, normalize: true, pooling: 'mean');
        if (!is_array($emb) || !isset($emb[0]) || !is_array($emb[0])) {
            throw new RuntimeException('Unexpected embeddings output format');
        }

        return $emb[0];
    }

    /**
     * Cosine similarity between two vectors.
     *
     * @param list<float|int> $a
     * @param list<float|int> $b
     * @return float
     */
    private function cosineSimilarity(array $a, array $b): float
    {
        $n = min(count($a), count($b));

        $dot = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        for ($i = 0; $i < $n; $i++) {
            $x = (float) $a[$i];
            $y = (float) $b[$i];

            $dot += $x * $y;
            $normA += $x * $x;
            $normB += $y * $y;
        }

        if ($normA <= 0.0 || $normB <= 0.0) {
            return 0.0;
        }

        return $dot / (sqrt($normA) * sqrt($normB));
    }

    /**
     * Load a JSON file and decode to array.
     *
     * @param string $path
     * @return array|null
     */
    private function loadJsonFile(string $path): ?array
    {
        if (!is_file($path)) {
            return null;
        }

        $raw = file_get_contents($path);
        if ($raw === false) {
            return null;
        }

        $data = json_decode($raw, true);
        return is_array($data) ? $data : null;
    }

    /**
     * Encode and save data to JSON file.
     *
     * @param string $path
     * @param array $data
     * @throws RuntimeException
     */
    private function saveJsonFile(string $path, array $data): void
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if ($json === false) {
            throw new RuntimeException('Failed to encode JSON');
        }

        $ok = file_put_contents($path, $json);
        if ($ok === false) {
            throw new RuntimeException('Failed to write cache file: ' . $path);
        }
    }

    /**
     * Load cached event embeddings only if they were produced by the current model.
     *
     * @return void
     */
    private function loadEmbeddingsFromCacheIfCompatible(): void
    {
        $cached = $this->loadJsonFile($this->cachePath);

        if (!is_array($cached) || !isset($cached['model'], $cached['events']) || !is_array($cached['events'])) {
            return;
        }

        if ($cached['model'] !== $this->model) {
            return;
        }

        foreach ($cached['events'] as $row) {
            if (isset($row['id'], $row['embedding']) && is_array($row['embedding'])) {
                $this->eventEmbeddingsById[(int) $row['id']] = $row['embedding'];
            }
        }
    }

    /**
     * Ensure embeddings exist for all events and persist them to cache.
     *
     * @return void
     * @throws RuntimeException
     */
    private function ensureAllEventEmbeddings(): void
    {
        $missing = [];
        foreach ($this->events as $event) {
            $id = (int) $event['id'];
            if (!isset($this->eventEmbeddingsById[$id])) {
                $missing[] = $event;
            }
        }

        if (count($missing) === 0) {
            return;
        }

        foreach ($missing as $event) {
            $id = (int) $event['id'];
            $text = (string) $event['description'];

            $this->eventEmbeddingsById[$id] = $this->embedText($text);
        }

        $toCache = [
            'model' => $this->model,
            'events' => array_values(array_map(
                fn(array $event): array => [
                    'id' => (int) $event['id'],
                    'embedding' => $this->eventEmbeddingsById[(int) $event['id']],
                ],
                $this->events
            )),
        ];

        $this->saveJsonFile($this->cachePath, $toCache);
    }

    /**
     * Score all events against the query embedding and return the top-N results.
     *
     * @param list<float|int> $queryVec
     * @return list<array{score:float,event:array{id:int,title:string,description:string}}>
     */
    private function search(array $queryVec): array
    {
        $scored = [];

        foreach ($this->events as $event) {
            $id = (int) $event['id'];
            $score = $this->cosineSimilarity($queryVec, $this->eventEmbeddingsById[$id]);

            $scored[] = [
                'score' => $score,
                'event' => $event,
            ];
        }

        usort($scored, static fn(array $a, array $b): int => $b['score'] <=> $a['score']);

        return array_slice($scored, 0, $this->topN);
    }

    /**
     * Render results as plain text.
     *
     * @param string $query
     * @param list<array{score:float,event:array{id:int,title:string,description:string}}> $results
     * @return void
     */
    public function render(string $query, array $results): void
    {
        echo "Query: {$query}\n\n";
        foreach ($results as $row) {
            $event = $row['event'];
            $score = (float) $row['score'];

            echo "[" . number_format($score, 4) . "] #{$event['id']} {$event['title']}\n";
            echo "  {$event['description']}\n\n";
        }
    }
}
