FROM php:8.2-fpm

# ------------------------------
# Install system dependencies
# ------------------------------
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    libxml2-dev \
    libcurl4-openssl-dev \
    libpng-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# ------------------------------
# Install PHP extensions
# ------------------------------
RUN docker-php-ext-install zip pdo_mysql bcmath xml mbstring curl gd pcntl

# ------------------------------
# Enable FFI
# ------------------------------
RUN apt-get update && apt-get install -y \
    libffi-dev \
    pkg-config \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install ffi
RUN echo "ffi.enable=1" > /usr/local/etc/php/conf.d/ffi.ini

# ------------------------------
# Install ONNX Runtime
# ------------------------------
ENV ONNXRUNTIME_VERSION=1.17.1

RUN curl -L https://github.com/microsoft/onnxruntime/releases/download/v${ONNXRUNTIME_VERSION}/onnxruntime-linux-x64-${ONNXRUNTIME_VERSION}.tgz \
    | tar -xz \
    && cp onnxruntime-linux-x64-${ONNXRUNTIME_VERSION}/lib/libonnxruntime.so* /usr/lib/ \
    && ldconfig \
    && rm -rf onnxruntime-linux-x64-${ONNXRUNTIME_VERSION}


# Install PEAR/PECL using the default PHP binary in the official image
# =====================================================================
#WORKDIR /tmp
#RUN curl -O https://pear.php.net/go-pear.phar \
#    && php go-pear.phar \
#    && rm go-pear.phar
#
## Install svm extension via PECL and enable it
#RUN pecl channel-update pecl.php.net \
#    && pecl install channel://pecl.php.net/svm-0.2.3 \
#    && mkdir -p /usr/local/etc/php/conf.d \
#    && echo "extension=svm.so" > /usr/local/etc/php/conf.d/svm.ini

## ------------------------------
## Install dependencies for Tensor
## ------------------------------
#RUN apt-get update && \
#    apt-get install -y \
#    libopenblas-dev \
#    libblas-dev \
#    liblapack-dev \
#    liblapacke-dev \
#    libatlas-base-dev \
#    gfortran \
#    gcc \
#    g++ \
#    make \
#    autoconf && \
#    ln -s /usr/include/x86_64-linux-gnu/cblas.h /usr/include/cblas.h
#
## Set BLAS environment variables
#ENV OPENBLAS_NUM_THREADS=1
#ENV GOTO_NUM_THREADS=1
#ENV OMP_NUM_THREADS=1
#
## Install the Tensor extension
#RUN pecl install tensor && \
#    docker-php-ext-enable tensor

# ------------------------------
# Install xDebug
# ------------------------------
# 1. Remove this xDebug to enable JIT compiler
# 2. Disable xDebug during execution, otherwise FFI + ONNX makes no sense.
# Install xDebug
# RUN pecl install xdebug && docker-php-ext-enable xdebug
# Create xdebug log file (if needed)
#RUN touch /var/log/xdebug.log
#RUN chown phishing:phishing /var/log/xdebug.log
#RUN chmod 775 /var/log/xdebug.log

# ------------------------------
# CONFIG files
# ------------------------------
COPY docker/app/conf.d/xdebug.ini /etc/php/8.2/mods-available/xdebug.ini
COPY docker/app/conf.d/opcache.ini /etc/php/8.2/mods-available/opcache.ini

# ------------------------------
# Install Composer
# ------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Configure PHP
RUN echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/docker-php-ram-limit.ini
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/docker-php-max-execution-time.ini

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
