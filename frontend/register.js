let selectedRole = "Teacher"; // Default role

// Handle role button clicks
const roleButtons = document.querySelectorAll(".role-select .role");
roleButtons.forEach(button => {
  button.addEventListener("click", () => {
    // Remove "active" from all buttons
    roleButtons.forEach(btn => btn.classList.remove("active"));
    
    // Add "active" to clicked button
    button.classList.add("active");

    // Save selected role
    selectedRole = button.textContent.trim();
  });
});
