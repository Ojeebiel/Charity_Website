<?php
  session_start();
  $account_id = $_SESSION['account_id'];
  // Redirect if not logged in
  if (!isset($_SESSION['account_id'])) {
      header("Location: ../index.php");
      exit;
  }

  require '../controller/gallery.process.php';
  $posts = fetchGalleryPosts($conn);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gallery</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&family=Jost:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital@0;1&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="gallery.css" />
</head>
<body>
  <header>
    <div class="tabFont"><a href="#">ELIZABETH FOUNDATION</a></div>

    <nav>
      <a href="gallery.php">HOME</a>
      <a href="fundraisers.php">FUNDRAISERS</a>
      <a href="initiate.php">INITIATE</a>
      <a href="#">LOG OUT</a>
    </nav>
  </header>

  <!-- 🖼️ GALLERY FEED -->
  <div class="ig-feed">

    <!-- 🖼️ Post -->
    <?php if (!empty($posts)): ?>
      <?php foreach ($posts as $post): ?>
        <div class="ig-post">
          <img src="<?php echo htmlspecialchars($post['image_path']); ?>" class="ig-img" alt="Post Image">
          <div class="ig-info">
            <p class="ig-caption"><?php echo htmlspecialchars($post['caption']); ?></p>
            <p class="ig-date"><?php echo date("F j, Y", strtotime($post['created_at'])); ?></p>
            <p class="ig-user"><strong><?php echo htmlspecialchars($post['user_name']); ?></strong></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No posts yet. Be the first to add one! 🌟</p>
    <?php endif; ?>



  </div>

  <!-- Floating Add Post Button -->
  <button class="add-post-btn" id="openModalBtn">＋</button>

  <!-- Modal -->
  <div class="post-modal" id="postModal">
    <div class="post-modal-content">
      <h3>Add New Post</h3>

      <form action="../controller/gallery.process.php" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="account_id" value="<?php echo htmlspecialchars($account_id); ?>">

        <textarea name="caption" placeholder="What's on your mind?" rows="4" required></textarea>

        <label class="upload-label">
          <input type="file" id="photoInput" name="photo" accept="image/*" hidden required>
          <img src="https://cdn-icons-png.flaticon.com/512/833/833281.png" alt="Attach" class="attach-icon">
          Add Photo
        </label>

        <div id="photoPreview"></div>

        <div class="modal-actions">
          <button type="button" id="cancelModalBtn" class="cancel">Cancel</button>
          <button type="submit" class="submit">Post</button>
        </div>
      </form>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 Elizabeth Foundation. All Rights Reserved.</p>
  </footer>

  <script>
  const openBtn = document.getElementById('openModalBtn');
  const cancelBtn = document.getElementById('cancelModalBtn');
  const modal = document.getElementById('postModal');
  const photoInput = document.getElementById('photoInput');
  const photoPreview = document.getElementById('photoPreview');

  // Toggle modal visibility
  openBtn.addEventListener('click', () => {
    modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
  });

  // Cancel button behavior
  cancelBtn.addEventListener('click', () => {
    modal.style.display = 'none';
    photoPreview.innerHTML = ''; // Clear preview when closing
    photoInput.value = '';       // Reset file input
  });

  // Preview only one photo
  photoInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        photoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width:100%;border-radius:10px;margin-top:10px;">`;
      };
      reader.readAsDataURL(file);
    } else {
      photoPreview.innerHTML = '';
    }
  });
  </script>
</body>
</html>
