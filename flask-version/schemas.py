from flask_marshmallow import Marshmallow
from models import Book

ma = Marshmallow()

# Schema for JSON serialization
class BookSchema(ma.SQLAlchemyAutoSchema):
    class Meta:
        model = Book
        load_instance = True

# Single and multiple schemas
book_schema = BookSchema()
books_schema = BookSchema(many=True)
