import requests

url = "http://127.0.0.1:5000/books"

books = [
    {"title": "Clean Code", "author": "Robert C. Martin", "year": 2008, "price": 29.99},
    {"title": "The Pragmatic Programmer", "author": "Andrew Hunt", "year": 1999, "price": 39.99},
    {"title": "Python Crash Course", "author": "Eric Matthes", "year": 2019, "price": 25.99}
]

for book in books:
    response = requests.post(url, json=book)
    print(response.json())
