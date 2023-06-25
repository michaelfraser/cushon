FROM starfruit3301/dev:2.0

ARG proxy

ENV PROJECT_ROOT=/var/www/demo/live/ \
    SSH_ROOT=/root/.ssh \
    http_proxy="${proxy}" \
    https_proxy="${proxy}"

RUN mkdir -p $PROJECT_ROOT $SSH_ROOT $PROJECT_ROOT/var/{cache,log} \
    && chown -R $USER:$USER $PROJECT_ROOT $SSH_ROOT

COPY entrypoint.sh /
COPY web.conf /etc/httpd/conf.d/

RUN chmod +x /entrypoint.sh

WORKDIR ${PROJECT_ROOT}

CMD ["apachectl", "-DFOREGROUND"]

ENTRYPOINT ["/entrypoint.sh"]
