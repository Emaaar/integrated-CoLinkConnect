<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enhanced Form Builder</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0ebf8;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .nav-container {
      background-color: #673ab7;
      color: white;
      padding: 10px 0;
    }
    .nav {
      display: flex;
      justify-content: flex-start;
      max-width: 768px;
      margin: 0 auto;
      padding: 0 20px;
    }
    .nav-item {
      padding: 15px 20px;
      color: #fff;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      border-bottom: 2px solid transparent;
    }
    .nav-item.active {
      border-bottom-color: #fff;
    }
    .container {
      width: 100%;
      max-width: 768px;
      margin: 20px auto;
      padding: 0 20px;
    }
    .form-title {
      background: #fff;
      padding: 24px;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
      margin-bottom: 12px;
    }
    .form-title input[type="text"] {
      width: 100%;
      border: none;
      font-size: 24px;
      font-weight: 600;
      color: #5f6368;
      padding: 8px 0;
      margin-bottom: 12px;
    }
    .form-title input[type="text"]:focus {
      outline: none;
    }
    .form-description {
      width: 100%;
      border: none;
      font-size: 14px;
      resize: none;
      padding: 8px 0;
      color: #5f6368;
    }
    .form-description:focus {
      outline: none;
    }
    .question-item {
      background: #fff;
      padding: 24px;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
      margin-bottom: 12px;
      position: relative;
    }
    .question-item input[type="text"] {
      width: 100%;
      border: none;
      font-size: 16px;
      padding: 8px 0;
      margin-bottom: 12px;
      color: #333;
    }
    .question-item input[type="text"]:focus {
      outline: none;
    }
    .question-type {
      position: absolute;
      top: 24px;
      right: 24px;
      font-size: 14px;
      background-color: #f0f0f0;
      border: none;
      border-radius: 4px;
      padding: 4px 8px;
      cursor: pointer;
    }
    .options input[type="text"] {
      width: calc(100% - 30px);
      border: none;
      font-size: 14px;
      padding: 8px;
      margin-left: 10px;
      color: #333;
      border-bottom: 1px solid #e0e0e0;
    }
    .options input[type="text"]:focus {
      outline: none;
      border-bottom: 1px solid #673ab7;
    }
    .add-option {
      color: #673ab7;
      background: none;
      border: none;
      padding: 0;
      font-size: 14px;
      cursor: pointer;
      margin-top: 12px;
    }
    .add-question {
      background-color: #673ab7;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 24px;
      cursor: pointer;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      margin-top: 12px;
    }
    .add-question:hover {
      background-color: #5e32ab;
    }
    .add-question i {
      margin-right: 8px;
    }
    .floating-icons {
      position: fixed;
      bottom: 20px;
      right: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .floating-icons button {
      background-color: #673ab7;
      color: #fff;
      border: none;
      width: 56px;
      height: 56px;
      border-radius: 50%;
      cursor: pointer;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }
    .floating-icons button:hover {
      background-color: #5e32ab;
    }
    .partner-info {
      background: #fff;
      padding: 24px;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
      margin-bottom: 12px;
      display: flex;
      gap: 16px;
      align-items: center;
    }
    .partner-info input[type="text"],
    .partner-info input[type="number"] {
      width: 100%;
      border: none;
      font-size: 16px;
      padding: 8px 0;
      color: #333;
    }
    .partner-info input[type="text"]:focus,
    .partner-info input[type="number"]:focus {
      outline: none;
    }
    .publish-link {
      background-color: #4caf50;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 24px;
      cursor: pointer;
      font-size: 14px;
      margin-top: 20px;
    }
    .publish-link:hover {
      background-color: #45a049;
    }
    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      width: 80%;
      max-width: 400px;
      text-align: center;
    }
    .modal-content button {
      background-color: #673ab7;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 24px;
      cursor: pointer;
    }
    .modal-content button:hover {
      background-color: #5e32ab;
    }
    .copy-icon {
      font-size: 18px;
      cursor: pointer;
    }
    .close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 24px;
  color: #673ab7;
  background: none;
  border: none;
  cursor: pointer;
}
.close-btn:hover {
  color: #5e32ab;
}
  </style>
</head>
<body>
<div class="nav-container">
  <nav class="nav">
    <a href="#" class="nav-item active">Questions</a>
    <a href="#" class="nav-item">Responses</a>
    <a href="#" class="nav-item">Settings</a>
     <!-- Publish Button -->
  <button class="publish-link" onclick="publishForm()">Publish</button>
</div>
  </nav>

 
<div class="container">
  <div class="form-title">
    <input type="text" id="form-title" value="Untitled Form" placeholder="Form Title">
    <textarea class="form-description" rows="1" placeholder="Form Description"></textarea>
    </div>
    <div class="partner-info">
    <input type="text" placeholder="Partner's Name">
    <input type="number" placeholder="Expected Number of Participants">
  </div>

  <div id="questions-container">
    <div class="question-item" id="question-1">
      <input type="text" placeholder="Question" class="question-title">
      <div class="question-type">
        <select onchange="updateQuestionType(this)">
          <option value="multiple-choice">Multiple Choice</option>
          <option value="checkbox">Checkbox</option>
          <option value="short-answer">Short Answer</option>
          <option value="paragraph">Paragraph</option>
        </select>
      </div>
      <div class="options" id="options-1">
        <div>
          <input type="text" placeholder="Option 1">
        </div>
        <div>
          <input type="text" placeholder="Option 2">
        </div>
      </div>
      <button class="add-option" onclick="addOption(this)">+ Add Option</button>
      <!-- Icon buttons for Duplicate and Remove -->
      <button class="duplicate-question" onclick="duplicateQuestion(this)" title="Duplicate Question">
        <i class="fas fa-copy"></i>
      </button>
      <button class="remove-question" onclick="removeQuestion(this)" title="Remove Question">
        <i class="fas fa-trash-alt"></i>
      </button>
      <!-- Switch button for Required -->
      <label class="switch">
        <input type="checkbox" onclick="toggleRequired(this)">
        <span class="slider"></span>
      </label>
      <span>Required</span>
    </div>
  </div>

  <button class="add-question" onclick="addQuestion()">+ Add Question</button>
<!-- Modal for Shareable Link -->
<div id="linkModal" class="modal">
  <div class="modal-content">
    <button class="close-btn" onclick="closeModal()">×</button> <!-- Close Button -->
    <h3>Form Published Successfully!</h3>
    <p><strong>Shareable Link:</strong> <span id="form-link-display"></span></p>
    <button onclick="copyLink()"><i class="fas fa-copy copy-icon"></i> Copy Link</button>
  </div>
</div>

<div class="floating-icons">
  <button onclick="addQuestion()" title="Add Question"><i class="fas fa-plus"></i></button>
  <button onclick="generatePDF()" title="Generate PDF"><i class="fas fa-file-pdf"></i></button>
</div>

<script>
  function closeModal() {
  document.getElementById("linkModal").style.display = "none";
}
    function publishForm() {
    // Generate the form URL (Example, you can modify this as per your requirement)
    const formLink = "https://yourform.com/form-id";
    document.getElementById("form-link-display").textContent = formLink;

    // Display the modal
    document.getElementById("linkModal").style.display = "flex";
  }

  function copyLink() {
    const formLink = document.getElementById("form-link-display").textContent;
    navigator.clipboard.writeText(formLink).then(() => {
      alert("Link copied to clipboard!");
    });
  }
  let questionCount = 1;

  function addQuestion() {
    questionCount++;
    const questionsContainer = document.getElementById("questions-container");

    const newQuestion = document.createElement("div");
    newQuestion.classList.add("question-item");
    newQuestion.id = `question-${questionCount}`;
    newQuestion.innerHTML = `
      <input type="text" placeholder="Question" class="question-title">
      <div class="question-type">
        <select onchange="updateQuestionType(this)">
          <option value="multiple-choice">Multiple Choice</option>
          <option value="checkbox">Checkbox</option>
          <option value="short-answer">Short Answer</option>
          <option value="paragraph">Paragraph</option>
        </select>
      </div>
      <div class="options" id="options-${questionCount}">
        <div>
          <input type="text" placeholder="Option 1">
        </div>
        <div>
          <input type="text" placeholder="Option 2">
        </div>
      </div>
      <button class="add-option" onclick="addOption(this)">+ Add Option</button>
      <!-- Icon buttons for Duplicate and Remove -->
      <button class="duplicate-question" onclick="duplicateQuestion(this)" title="Duplicate Question">
        <i class="fas fa-copy"></i>
      </button>
      <button class="remove-question" onclick="removeQuestion(this)" title="Remove Question">
        <i class="fas fa-trash-alt"></i>
      </button>
      <!-- Switch button for Required -->
      <label class="switch">
        <input type="checkbox" onclick="toggleRequired(this)">
        <span class="slider"></span>
      </label>
      <span>Required</span>
    `;
    questionsContainer.appendChild(newQuestion);
  }

  function addOption(button) {
    const optionsContainer = button.previousElementSibling;
    const optionCount = optionsContainer.children.length + 1;
    const newOption = document.createElement("div");
    newOption.innerHTML = `
      <input type="text" placeholder="Option ${optionCount}">
    `;
    optionsContainer.appendChild(newOption);
  }

  function removeQuestion(button) {
    const questionItem = button.closest(".question-item");
    questionItem.remove();
  }

  function duplicateQuestion(button) {
    const questionItem = button.closest(".question-item");
    const clonedQuestion = questionItem.cloneNode(true);
    questionCount++;
    clonedQuestion.id = `question-${questionCount}`;
    document.getElementById("questions-container").appendChild(clonedQuestion);
  }

  function toggleRequired(input) {
    const questionItem = input.closest(".question-item");
    const inputFields = questionItem.querySelectorAll("input");
    inputFields.forEach(inputField => {
      inputField.required = input.checked;
    });
  }

  function updateQuestionType(selectElement) {
    const selectedType = selectElement.value;
    const questionItem = selectElement.closest(".question-item");
    const optionsContainer = questionItem.querySelector(".options");
    const addOptionButton = questionItem.querySelector(".add-option");

    if (selectedType === "short-answer" || selectedType === "paragraph") {
      optionsContainer.style.display = "none";
      addOptionButton.style.display = "none";
    } else if (selectedType === "checkbox" || selectedType === "multiple-choice") {
      optionsContainer.style.display = "block";
      addOptionButton.style.display = "block";
    }
  }

  function generateFormLink() {
    alert("Feature to generate form link is coming soon!");
  }

  function generatePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    const title = document.getElementById("form-title").value;
    const description = document.querySelector(".form-description").value;

    doc.text(`Form Title: ${title}`, 10, 10);
    doc.text(`Description: ${description}`, 10, 20);

    const questions = document.querySelectorAll(".question-item");
    questions.forEach((question, index) => {
      const questionText = question.querySelector(".question-title").value;
      doc.text(`${index + 1}. ${questionText}`, 10, 30 + index * 10);
    });

    doc.save("form.pdf");
  }
  function submitForm() {
    const questions = [];
    document.querySelectorAll('.question-item').forEach((questionElement) => {
        const questionTitle = questionElement.querySelector('.question-title').value;
        const questionType = questionElement.querySelector('.question-type select').value;
        const options = [];
        questionElement.querySelectorAll('.options input[type="text"]').forEach(optionInput => {
            options.push(optionInput.value);
        });

        questions.push({
            title: questionTitle,
            type: questionType,
            options: options
        });
    });

    // Attach the questions to the form data
    const formData = new FormData();
    formData.append('form_title', document.getElementById('form-title').value);
    formData.append('form_description', document.querySelector('.form-description').value);
    formData.append('partner_name', document.querySelector('.partner-info input[type="text"]').value);
    formData.append('participants', document.querySelector('.partner-info input[type="number"]').value);
    formData.append('questions', JSON.stringify(questions));

    fetch('/needs-assessment/submit', {
        method: 'POST',
        body: formData
    }).then(response => response.json())
      .then(data => {
          alert('Form submitted successfully!');
      }).catch(error => {
          console.error('Error submitting form:', error);
      });
}
</script>
</body>
</html>