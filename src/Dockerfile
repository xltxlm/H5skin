FROM registry.cn-hangzhou.aliyuncs.com/xialintai/ssh
COPY / /var/www/html/
COPY /docker-entrypoint.sh /root/

#版本号
RUN echo "v@"$(date +%Y%m%d%H%M%S) >/v
RUN chmod +x /root/docker-entrypoint.sh
#作为其他镜像的目录
VOLUME /var/www/html/
WORKDIR /var/www/html/