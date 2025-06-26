<!-- index.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AI Quiz Maker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background: #f8f9fa;
    }
    .card {
      max-width: 600px;
      margin: auto;
      margin-top: 50px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .form-check-label {
      text-transform: capitalize;
    }
  </style>
  <script>
  function toggleInput(checkbox) {
    const input = checkbox.closest('.type-group').querySelector('input[type="number"]');
    input.disabled = !checkbox.checked;
    if (!checkbox.checked) input.value = "";
    updateTotal();
  }

  // Update total on every input change
  function updateTotal() {
    const countInputs = document.querySelectorAll('input[type="number"]:not(:disabled)');
    let total = 0;
    countInputs.forEach(input => {
      const val = parseInt(input.value);
      if (!isNaN(val)) total += val;
    });
    document.getElementById('totalCount').textContent = total;
  }

  // Also update total live on input
  document.addEventListener('DOMContentLoaded', () => {
    const countInputs = document.querySelectorAll('input[type="number"]');
    countInputs.forEach(input => {
      input.addEventListener('input', updateTotal);
    });
  });
</script>

</head>
<body>
  <div class="container">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">📄 AI Quiz Generator</h2>

         <?php if (isset($_SESSION['message'])): ?>
          <div class="alert alert-info"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <form action="generate.php" method="POST" enctype="multipart/form-data">
          <!-- File Upload -->
          <div class="mb-3">
            <label for="file" class="form-label">Upload Lesson File (.pdf, .docx, .txt)</label>
            <input type="file" name="file" id="file" class="form-control" required accept=".pdf,.docx,.txt">
          </div>

          <!-- Question Types and Counts -->
          <div class="mb-3">
            <label class="form-label">Select question types and count:</label>

            <div class="type-group">
              <input class="form-check-input" type="checkbox" name="types[multiple]" id="mcq" onchange="toggleInput(this)">
              <label class="form-check-label" for="mcq">Multiple Choice</label>
              <input type="number" name="counts[multiple]]" class="form-control form-control-sm" placeholder="0" min="0" max="50" disabled>
            </div>

            <div class="type-group">
              <input class="form-check-input" type="checkbox" name="types[enumeration]" id="enum" onchange="toggleInput(this)">
              <label class="form-check-label" for="enum">Enumeration</label>
              <input type="number" name="counts[enumeration]" class="form-control form-control-sm" placeholder="0" min="0" max="50" disabled>
            </div>

            <div class="type-group">
              <input class="form-check-input" type="checkbox" name="types[truefalse]" id="yn" onchange="toggleInput(this)">
              <label class="form-check-label" for="yn">True or False</label>
              <input type="number" name="counts[truefalse]" class="form-control form-control-sm" placeholder="0" min="0" max="50" disabled>
            </div>

            <div class="type-group">
              <input class="form-check-input" type="checkbox" name="types[fill]" id="fib" onchange="toggleInput(this)">
              <label class="form-check-label" for="fib">Fill in the Blanks</label>
              <input type="number" name="counts[fill]" class="form-control form-control-sm" placeholder="0" min="0" max="50" disabled>
            </div>
          </div>
          <?php // Added for test tracking?>
          <div class="type-group">
            <input type="text" class="form-control form-control-sm">
          </div>
          
            <div class="mb-3 text-end">
                <div class="alert alert-warning py-2 px-3 mb-2" id="totalDisplay">
                    Total items: <strong id="totalCount">0</strong>
                </div>
            </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Generate Quiz</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
