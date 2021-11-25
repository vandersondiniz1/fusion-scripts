#!/bin/bash

branch='master'

git checkout $branch
git pull origin $branch && git fetch --all

echo "Informe o numero da ENG: "
read eng_number

echo "Bug(B), Melhoria(M) ou Hotfix?: "
read eng_type

if [ $eng_type == 'B' ]; then
    rotulo='feature/ENG-B-I'$eng_number'-deploy'
elif [ $eng_type == 'M' ]; then
    rotulo='feature/ENG-M-I'$eng_number'-deploy'
elif [ $eng_type == 'H' ]; then
    rotulo='feature/ENG-H-I'$eng_number'-deploy' #fixme - verificar se o rotulo eh esse mesmo
else
    echo "Opção inválida"
fi

git checkout -b $rotulo

continue='s'

# while :; do
#     read -p "Informe o hash (q to quit) : " hash
#     if [ $hash == 'q' ]; then
#         break
#     fi
#     echo "Vai continuar"
#     git cherry-pick $hash
#     git add .
#     git commit -m "Commit $rotulo realizado"
# done

git checkout $branch

git branch -d $rotulo
