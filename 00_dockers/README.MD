# 📦 Docker Templates for Studies and Projects

This folder contains `Dockerfile` and `docker-compose` files ready for use in different stacks (Laravel, Django, Node.js), as well as the central database (Postgres + MongoDB).

The idea is to reuse these files in any project by calling them from the project folder.

---

## 🚀 How to Use

### 1. Start the central database (Postgres + MongoDB)

```bash
cd ~/project/erp-sample
docker compose -f ../00_dockers/docker-compose.db.yml up -d
```

- **Postgres**: `localhost:5432`
- **MongoDB**: `localhost:27017`
- Username and password are set in `docker-compose.db.yml`.

---

### 2. Start a Laravel project

```bash
cd ~/project/erp-sample
docker compose -f ../00_dockers/docker-compose.laravel.yml up -d --build
```

Server available at: [http://localhost:8000](http://localhost:8000)

---

### 3. Start a Django project

```bash
cd ~/project/django-sample
docker compose -f ../00_dockers/docker-compose.django.yml up -d --build
```

Server available at: [http://localhost:8000](http://localhost:8000)

---

### 4. Start a Node.js / React project

```bash
cd ~/project/node-sample
docker compose -f ../00_dockers/docker-compose.node.yml up -d --build
```

Server available at: [http://localhost:3000](http://localhost:3000)

---

## 📂 Recommended Folder Structure

```
projects/
│
├── 00_dockers/              # Central folder with Dockerfiles and docker-compose
│   ├── Dockerfile.laravel
│   ├── Dockerfile.django
│   ├── Dockerfile.node
│   ├── docker-compose.db.yml
│   ├── docker-compose.laravel.yml
│   ├── docker-compose.django.yml
│   └── docker-compose.node.yml
│
├── erp-sample/              # Laravel project
│   └── ...
│
├── django-sample/           # Django project
│   └── ...
│
└── node-sample/             # Node.js / React project
    └── ...
```

---

## ➕ Adding New Projects

1. Create the project folder inside `projects/`.
2. Create a `docker-compose` for the project pointing to the central database:
   ```yaml
   services:
     app:
       build: .
       container_name: container_name
       volumes:
         - .:/app
       ports:
         - "local_port:container_port"
       environment:
         DB_HOST=host.docker.internal
         DB_PORT=5432
         DB_USER=emerson
         DB_PASSWORD=secret123
         DB_NAME=mydb
   ```
3. Run:
   ```bash
   cd ~/projects/project-name
   docker compose -f ../00_dockers/docker-compose.name.yml up -d --build
   ```

---

## 🗑️ Stop and Remove Containers

To stop a specific project:

```bash
docker compose -f ../00_dockers/docker-compose.laravel.yml down
```

To stop all containers (database + apps):

```bash
docker ps -q | xargs docker stop
```

---

## 💾 Database Backup & Restore

### PostgreSQL

```bash
# Backup
docker exec -t postgres_db pg_dump -U emerson mydb > ./backups/pg_mydb.sql

# Restore
cat ./backups/pg_mydb.sql | docker exec -i postgres_db psql -U emerson -d mydb
```

### MongoDB

```bash
# Backup
docker exec mongo_db mongodump --username emerson --password secret123 --out /backups/mongo_dump

# Restore
docker exec mongo_db mongorestore --username emerson --password secret123 /backups/mongo_dump
```

> Use Google Drive to store backups and synchronize between machines without affecting Docker volumes.

---

## 💡 Tips

- All projects share the **same central database** (Postgres + Mongo).
- The **context (` `)** is always the project folder where you run the command, so each project keeps its own files while Docker files come from `00_dockers`.
- Make regular database backups using the commands above to keep data synchronized between machines.
- For new courses/projects, just create the folder and point the `docker-compose` to the central database.
- This setup allows you to study or work on any machine using **the same environment and database**.

