# Stage 1: Build assets
FROM node:lts-alpine AS builder

WORKDIR /var/www

COPY . /var/www

RUN npm install && npm run build

FROM nginx:stable-alpine

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

COPY --from=builder /var/www/public /var/www/public

WORKDIR /var/www/public

EXPOSE 80 443

CMD ["nginx", "-g", "daemon off;"]