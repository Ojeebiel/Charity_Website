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

  // Expand/Collapse captions
  document.querySelectorAll('.ig-caption').forEach(caption => {
    caption.addEventListener('click', () => {
      caption.classList.toggle('expanded');
    });
  });