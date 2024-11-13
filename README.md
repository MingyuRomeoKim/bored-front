# 실행 방법

## 1. 프로젝트 설정
[1-1] 프로젝트를 클론합니다.
```bash
git clone https://github.com/MingyuRomeoKim/laravel-playground.git
```
[1-2] 프로젝트 루트 디렉토리에서 .env.example 파일을 복사하여 .env 파일을 생성합니다.

[1-3] .env 파일을 열어서 환경 변수를 설정합니다.

## 2. 도커 설정
[2-1] docker directory로 이동합니다.
```bash
cd docker
```
[2-2] 도커 디렉토리에서 .env.example 파일을 복사하여 .env 파일을 생성합니다. 

[2-3] docker-compose.yml 파일을 기준으로 컨테이너를 생성합니다.
```bash
docker-compose up -d
```

## 3. 프로젝트 실행
[3-1] 컴포저 설치하기
```bash
docker exec laravel-playground composer install
```

[3-2] 애플리케이션 키 생성
```bash
docker exec laravel-playground php artisan key:generate
```

[3-3] 마이그레이션 실행
```bash
docker exec laravel-playground php artisan migrate
```

## 4. certbot 설정
certbot contianer로 이동합니다.
```bash
docker exec -it certbot /bin/bash
```
SKB 이용자인 저는 80포트를 사용할 수 없기 때문에 certbot container에서 dns 인증 방법 사용으로 certbot을 실행합니다.
```bash
sudo certbot -d your-domain --manual --preferred-challenges dns certonly
```


