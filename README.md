# Laravel-FastAPI-AI

A microservices demo integrating Laravel (PHP) and FastAPI (Python) with sentiment analysis powered by Hugging Face models.

## Features
- **Microservices Architecture**: Laravel handles the frontend and user interface, FastAPI processes AI-driven sentiment analysis.
- **Docker Compose**: Integrates PHP and Python environments for easy setup.
- **REST API**: Laravel communicates with FastAPI via HTTP requests.
- **Hugging Face Model**: Uses `distilbert-base-uncased-finetuned-sst-2-english` for sentiment analysis.
- **Future Extensions**: Upgrade to complex AI models (e.g., real-time recommendation systems).

## Screenshots
![Comment Form](screenshots/comment_form.png)
![Sentiment Result](screenshots/sentiment_result.png)

## Project Structure
```
.
├── laravel-app/                # Laravel frontend application
│   ├── app/
│   │   └── Http/
│   │       └── Controllers/
│   │           └── CommentController.php
│   ├── resources/
│   │   └── views/
│   │       └── comment.blade.php
│   ├── routes/
│   │   └── web.php
│   ├── .env.example
│   ├── Dockerfile
│   └── composer.json
├── fastapi-app/                # FastAPI sentiment analysis microservice
│   ├── main.py
│   ├── requirements.txt
│   ├── .env.example
│   └── Dockerfile
├── docker-compose.yml          # Docker Compose configuration
├── .gitignore                  # Git ignore file
└── README.md                   # Project documentation
```

## Prerequisites
- Docker
- Docker Compose
- Git

## Setup Instructions
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/BpsEason/laravel-fastapi-ai.git
   cd laravel-fastapi-ai
   ```

2. **Create Laravel Project (if not already created)**:
   ```bash
   cd laravel-app
   docker run --rm -v $(pwd):/app composer create-project laravel/laravel .
   ```

3. **Install Guzzle in Laravel**:
   ```bash
   cd laravel-app
   docker run --rm -v $(pwd):/app composer require guzzlehttp/guzzle
   ```

4. **Copy Environment Files**:
   - Copy `laravel-app/.env.example` to `laravel-app/.env`:
     ```bash
     cp laravel-app/.env.example laravel-app/.env
     ```
   - Copy `fastapi-app/.env.example` to `fastapi-app/.env`:
     ```bash
     cp fastapi-app/.env.example fastapi-app/.env
     ```

5. **Generate Laravel APP_KEY**:
   ```bash
   cd laravel-app
   docker run --rm -v $(pwd):/app composer php artisan key:generate
   ```

6. **Copy Provided Files**:
   - Place `CommentController.php`, `comment.blade.php`, `web.php`, `composer.json`, and `Dockerfile` in `laravel-app`.
   - Place `main.py`, `requirements.txt`, and `Dockerfile` in `fastapi-app`.
   - Place `docker-compose.yml` and `.gitignore` in the root directory.

7. **Build and Start Services**:
   ```bash
   docker-compose up --build -d
   ```

8. **Access the Application**:
   - Laravel frontend: `http://localhost:8000`
   - FastAPI docs: `http://localhost:8001/docs`

## Usage
1. Open `http://localhost:8000` in your browser.
2. Enter a comment (e.g., "I love this product!" or "This is terrible.").
3. Submit the form to see the sentiment analysis result (Positive/Negative) and confidence score.

## Testing
- Test FastAPI endpoint:
  ```bash
  curl -X POST http://localhost:8001/analyze-sentiment/ -H "Content-Type: application/json" -d '{"text":"I love this product!"}'
  ```
  Expected response: `{"label":"POSITIVE","score":0.9998981952667236}`

## Docker Compose Commands
- Stop services: `docker-compose down`
- View logs: `docker-compose logs laravel` or `docker-compose logs fastapi`
- Rebuild: `docker-compose build`
- Restart: `docker-compose restart`

## Future Extensions
- Upgrade FastAPI to use advanced AI models (e.g., BERT or GPT for recommendation systems).
- Add Redis caching for AI predictions.
- Implement OAuth2 authentication for secure API access.
- Extend to real-time recommendation systems based on user comments.

## Troubleshooting
- **Laravel errors**: Check logs in `laravel-app/storage/logs/laravel.log`.
- **FastAPI errors**: Check container logs with `docker-compose logs fastapi`.
- **CORS issues**: Ensure `fastapi-app/.env` has correct `CORS_ALLOW_ORIGIN`.
- **Model loading issues**: Ensure sufficient memory (4GB+ RAM) and stable internet for Hugging Face model download.

## License
MIT