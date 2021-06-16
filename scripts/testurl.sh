#!/bin/bash
url=`cat stack.json | jq -r '.HttpApiUrl'`
echo "TEST_URL=$url" >> .env