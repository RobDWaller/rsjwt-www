# ReallySimpleJWT Website

## Run Locally

```
docker-compose up -d

docker-compose exec rsjwt-www bash
```

## Serverless Configuration

```
serverless config credentials --provider aws --key <key> --secret <secret>
```

## Useful Serverless Commands

```
serverless deploy

serverless remove

serverless deploy -s dev

serverless info -s dev
```

## JQ Commands

```
cat stack.json | jq -r '.HttpApiUrl'
```

## Useful Resources
- [Bref Documentation](https://bref.sh/docs/) 