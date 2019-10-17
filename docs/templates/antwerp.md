---
layout: default
title: Antwerp
parent: Templates
nav_order: 1
---
# The Antwerp Template
{: .no_toc }

The Antwerp template is a feature densed template with lots of customisation. 

## Table of contents
{: .no_toc .text-delta }

1. TOC
{:toc}

## Image

![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 1")

## Installation

- Install through Composer

``` composer require chuckbe/chuckcms-template-antwerp ```

- Publish the theme to your database

``` php artisan chuckcms-template-antwerp:publish ```

- Publish the assets of the theme to your `/public` folder

``` php artisan vendor:publish --tag=chuckcms-template-antwerp-public --force ```

> If you add your own blocks to the theme don't use the --force tag when republishing.