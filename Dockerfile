FROM ubuntu:24.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get -qq update && apt-get install -y --no-install-recommends \
    software-properties-common \
    curl \
    gnupg \
    git \
    vim-nox \
    lsb-release \
    apt-transport-https
RUN add-apt-repository ppa:ondrej/php -y && \
    apt-get -qq update

RUN apt-get install -y --no-install-recommends \
    php5.6-cli \
    php5.6-zip \
    php5.6-mysql \
    php5.6-curl \
    php5.6-mbstring \
    php5.6-json \
    php5.6-pdo \
    php5.6-xml && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

USER ubuntu