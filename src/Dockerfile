FROM registry.cn-hangzhou.aliyuncs.com/xialintai/codepack
COPY / /var/www/html/

#版本号
RUN echo "v@"$(date +%Y%m%d%H%M%S) >/v
#作为其他镜像的目录
VOLUME /var/www/html/
WORKDIR /var/www/html/