#!/bin/bash

#pegar o usuario da maquina
user=$whoami

#verificar se o bashrc existe
if [ -f ~/.bashrc ]; then
    mv ~/.bashrc ~/.bashrc.bkp
    cat aliases >> ~/.bashrc
else
    touch ~/.bashrc
    cat aliases >> ~/.bashrc
fi

#verificar se o .bashrc.bkp ja existe

source ~/.bashrc
