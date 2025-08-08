
##  API Endpoints Using GET Method

> All URLs assume you're running from: `http://localhost:8000`

### 🔹 1. Get All Posts
**File:** `api/all_posts.php`  
**Method:** GET  
**Example:**  
```
http://localhost:8000/api/all_posts.php
```

---

### 🔹 2. Get Post by ID
**File:** `api/post_by_id.php`  
**Method:** GET  
**Parameters:**
- `id` → ID of the post  
**Example:**
```
http://localhost:8000/api/post_by_id.php?id=1
```

---

### 🔹 3. Get Posts by User
**File:** `api/user_posts.php`  
**Method:** GET  
**Parameters:**
- `user_id` → ID of the user  
**Example:**
```
http://localhost:8000/api/user_posts.php?user_id=2
```

---

### 🔹 4. Update Comment (POST or GET for testing)
**File:** `api/update_comment.php`  
**Method:** POST (but can use GET for quick testing)  
**Parameters:**
- `comment_id`  
- `content`  


http://localhost:8000/api/update_comment.php?comment_id=5&content=Updated+comment
```

---
### 🔹 5. Delete Post (Post or GET for testing)
**File:** `api/delete_post.php`  
**Method:** GET (for simple testing)  
**Parameters:**
- `id` → ID of the post to delete  


http://localhost:8000/api/delete_post.php?id=3
```




