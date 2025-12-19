<?php
// Feedback modal (Materialize)
?>
<div id="feedback-modal" class="modal">
  <div class="modal-content">
    <h4>Send Feedback</h4>
    <form id="feedback-form">
      <div class="input-field">
        <input id="fb_name" name="name" type="text" required>
        <label for="fb_name">Your name</label>
      </div>

      <div class="input-field">
        <input id="fb_email" name="email" type="email" required>
        <label for="fb_email">Email</label>
      </div>

      <div class="input-field">
        <select id="fb_rating" name="rating">
          <option value="" disabled selected>Rate (optional)</option>
          <option value="5">5 - Excellent</option>
          <option value="4">4 - Very Good</option>
          <option value="3">3 - Good</option>
          <option value="2">2 - Fair</option>
          <option value="1">1 - Poor</option>
        </select>
        <label for="fb_rating">Rating</label>
      </div>

      <div class="input-field">
        <textarea id="fb_message" name="message" class="materialize-textarea" required></textarea>
        <label for="fb_message">Message</label>
      </div>

      <div class="input-field">
        <button id="feedback-submit" class="btn waves-effect waves-light" type="submit">Send</button>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close btn-flat">Close</a>
  </div>
</div>

<script>
  // Initialize select for Materialize when modal is opened
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('#feedback-modal select');
    if (elems.length) M.FormSelect.init(elems);
  });
</script>


