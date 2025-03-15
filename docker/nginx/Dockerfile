# Stage 1: Build assets
FROM alpine AS builder

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    nodejs \
    npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY . /var/www

RUN npm install && npm run build

FROM nginx:alpine

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

COPY --from=builder /var/www/public /var/www/public

WORKDIR /var/www/public

EXPOSE 80 443

CMD ["nginx", "-g", "daemon off;"]