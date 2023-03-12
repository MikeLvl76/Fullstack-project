<details>
<summary><b>About</b></summary>
  <br/>
</details>

<details open>
  <summary><b>Get started</b></summary>
  <br/>
  <p>

 - Build the container :

```bash
docker compose build --pull --no-cache
```

- Launch docker-compose file and build images :

```bash
docker compose up -d
```

- Install Composer packages :

```bash
docker compose exec php composer install
```

- Then you have to uodate database with :

```bash
docker compose exec php bin/console doctrine:migrations:diff
docker compose exec php bin/console doctrine:migrations:migrate
docker compose exec php bin/console doctrine:fixtures:load --no-debug # takes time
```

- View logs :

```bash
docker compose logs -f
```
  </p>
</details>