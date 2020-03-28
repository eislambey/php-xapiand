#!/usr/bin/env bash
docker run \
-p 8880:8880 \
-v xapiand-data:/var/db \
--rm dubalu/xapiand:0.29.0 \
--name xapiand-server
