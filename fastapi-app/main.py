from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from transformers import pipeline
from fastapi.middleware.cors import CORSMiddleware
from dotenv import load_dotenv
import os

# Load environment variables
load_dotenv()

app = FastAPI(title="Sentiment Analysis Microservice")

# Enable CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=[os.getenv("CORS_ALLOW_ORIGIN", "http://localhost:8000")],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Load Hugging Face sentiment analysis model
sentiment_analyzer = pipeline("sentiment-analysis", model="distilbert-base-uncased-finetuned-sst-2-english")

# Pydantic model for request
class Comment(BaseModel):
    text: str

# Pydantic model for response
class SentimentResponse(BaseModel):
    label: str
    score: float

@app.post("/analyze-sentiment/", response_model=SentimentResponse)
async def analyze_sentiment(comment: Comment):
    if not comment.text.strip():
        raise HTTPException(status_code=400, detail="Comment cannot be empty")
    
    result = sentiment_analyzer(comment.text)[0]
    return SentimentResponse(label=result["label"], score=result["score"])