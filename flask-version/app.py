from flask import Flask, request, jsonify
from models import db, Book
from schemas import ma, book_schema, books_schema

# Initialize Flask app
app = Flask(__name__)
app.config["SQLALCHEMY_DATABASE_URI"] = "sqlite:///books.db"
app.config["SQLALCHEMY_TRACK_MODIFICATIONS"] = False

# Init db + marshmallow
db.init_app(app)
ma.init_app(app)

# Create database tables
with app.app_context():
    db.create_all()

# Routes
@app.route("/books", methods=["POST"])
def add_book():
    data = request.json
    new_book = Book(
        title=data["title"],
        author=data["author"],
        year=data.get("year"),
        price=data.get("price"),
    )
    db.session.add(new_book)
    db.session.commit()
    return book_schema.jsonify(new_book), 201


@app.route("/books", methods=["GET"])
def get_books():
    books = Book.query.all()
    return books_schema.jsonify(books)


@app.route("/books/<int:id>", methods=["GET"])
def get_book(id):
    book = Book.query.get_or_404(id)
    return book_schema.jsonify(book)


@app.route("/books/<int:id>", methods=["PUT"])
def update_book(id):
    book = Book.query.get_or_404(id)
    data = request.json
    book.title = data.get("title", book.title)
    book.author = data.get("author", book.author)
    book.year = data.get("year", book.year)
    book.price = data.get("price", book.price)
    db.session.commit()
    return book_schema.jsonify(book)


@app.route("/books/<int:id>", methods=["DELETE"])
def delete_book(id):
    book = Book.query.get_or_404(id)
    db.session.delete(book)
    db.session.commit()
    return jsonify({"message": "Book deleted successfully"})

@app.route("/", methods=["GET"])
def home():
    return "📚 Welcome to Bookstore API! Use /books to see all books."

if __name__ == "__main__":
    app.run(debug=True)
