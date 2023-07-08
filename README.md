## PHP MNIST

In this project i'm using the [php fann connector](https://github.com/bukka/php-fann) for the [FANN](http://leenissen.dk/fann/wp/) library
to develop an [OCR](https://en.wikipedia.org/wiki/Optical_character_recognition) based on the [MNIST](http://yann.lecun.com/exdb/mnist/) dataset.

## Installation

```bash
sudo apt install libfann-dev libfann2
pecl install fann # get the dll here http://pecl.php.net/package/fann if you are using windows
git clone https://github.com/mauri870/php-fann-mnist
cd php-fann-mnist
```

You can also use a docker container to try the project:

```bash
docker run -it php:latest bash
```

## Usage

### Download the dataset and generate FANN files

First you need to download the mnist dataset, for that run the following commands:

```bash
mkdir -p data
NAMES="train-images-idx3-ubyte train-labels-idx1-ubyte t10k-images-idx3-ubyte t10k-labels-idx1-ubyte"
for n in $NAMES; do
    echo "Downloading $n..."
    wget -qO- http://yann.lecun.com/exdb/mnist/$n.gz | gunzip -c > data/$n
done
```

Next generate the train/test and validation files for FANN
```bash
php preprocess.php
```

### Train

```bash
php train.php
```

Since FANN rely only on cpu computations, you can expect a training time of ~40 minutes on an octa core processor

### Test

```bash
php test.php
```
