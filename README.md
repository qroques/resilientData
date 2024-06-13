# Resilient Data

> [!WARNING]
> This project is a work in progress. The code is not yet fully functional.

## Overview

Resilient Data is a library that provides classes to work with data in a resilient way. Tipically, a data is splitted into multiple parts, and each part can be stored in different locations. This library provides classes to work with this kind of data and recover the inital data even if some parts are missing.

## Example

You have 4 associates, and you want to split a secret into 4 parts, so that each associate has one part. You want the secret to be recoverable if at least 3 associates are present. This means that if you lose one associate, you can still recover the secret. To do so, this library will split the secret into multiple parts (chunks) and distribute them to the associates. To ensure redundancy, each chunk will be duplicated and distributed to two associates.

|Chunk|Associate 1|Associate 2|Associate 3|Associate 4|
|---|---|---|---|---|
|A|X|X| | |
|B|X| |X| |
|C|X| | |X|
|D| |X|X| |
|E| |X| |X|
|F| | |X|X|

