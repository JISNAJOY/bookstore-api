from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

# Database model
class Book(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(150), nullable=False)
    author = db.Column(db.String(100), nullable=False)
    year = db.Column(db.Integer)
    price = db.Column(db.Float)
