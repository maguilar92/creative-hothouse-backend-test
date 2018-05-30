FROM node:alpine

MAINTAINER Julien Tant <julien@craftyx.fr>

RUN npm update -g

# Install everything (and clean up afterwards)
RUN apk --update add --no-cache --virtual \
    autoconf \
    automake \
    freetype-dev \
	g++ \
	gcc \
	jpeg-dev \
	lcms2-dev \
	libffi-dev \
	libpng-dev \
	libwebp-dev \
	linux-headers \
	make \
	openjpeg-dev \
	openssl-dev \
	python2-dev \
	tiff-dev \
    build-base \
    libtool \
    nasm

# Define working directory.
WORKDIR /var/www/html