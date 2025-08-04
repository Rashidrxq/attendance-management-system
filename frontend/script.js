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



document.addEventListener("DOMContentLoaded", function () {
  // Toggle active role
  document.querySelectorAll(".role").forEach(button => {
    button.addEventListener("click", function () {
      document.querySelectorAll(".role").forEach(btn => btn.classList.remove("active"));
      this.classList.add("active");
      document.getElementById("selectedRole").value = this.textContent.trim();
    });
  });

  // Handle login form submission
  const form = document.querySelector(".login-form");

  if (!form) {
    console.error("Login form not found!");
    return;
  }

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const username = document.querySelector('input[name="username"]').value;
    const password = document.querySelector('input[name="password"]').value;
    const roleButton = document.querySelector('.role.active');

    if (!roleButton) {
      alert("Please select a role");
      return;
    }

    const role = document.getElementById("selectedRole").value.toLowerCase();

    fetch("/ATM/backend/api/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}&role=${encodeURIComponent(role)}`
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          localStorage.setItem("user_id", data.user.id);
          if (data.user.role === "student") {
            window.location.href = "student.html";
          } else if (data.user.role === "teacher") {
            window.location.href = "teacher.html";
          } else if (data.user.role === "admin") {
            window.location.href = "admin.html";
          }
        } else {
          alert(data.message);
        }
      })
      .catch(err => {
        console.error("Login error:", err);
        alert("Server error. Try again.");
      });
  });
});




function markAttendance() {
  const userId = localStorage.getItem("user_id");
  if (!userId) return;

  fetch(`/atm/backend/api/mark_attendance.php`, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `user_id=${encodeURIComponent(userId)}`
  })
    .then(res => res.json())
    .then(data => {
      const msg = document.getElementById("markMsg");
      if (data.success) {
        msg.textContent = "Attendance marked successfully!";
        msg.style.color = "green";
        fetchAttendanceHistory(); // reload history
      } else {
        msg.textContent = data.message;
        msg.style.color = "red";
      }
    })
    .catch(err => {
      alert("Error marking attendance");
      console.error(err);
    });
}

function logout() {
  alert("Logging out...");
  window.location.href = "index.html"; // redirect to login
}

// Add this function to script.js

function fetchAndShowStudentData() {
  const userId = localStorage.getItem("user_id");
  if (!userId) return;

  fetch(`/atm/backend/api/get_student.php?id=${userId}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById("studentName").textContent = data.user.first_name + " " + data.user.last_name;
        document.getElementById("studentId").textContent = data.user.id;
        document.getElementById("studentClass").textContent = data.user.department || "";
        document.getElementById("email").textContent = data.user.email || "";
        document.getElementById("address").textContent = data.user.address || "";
      } else {
        alert("Student not found");
      }
    })
    .catch(err => {
      alert("Error fetching student data");
      console.error(err);
    });
}

// Call this on page load in student.html
window.onload = function() {
  fetchAndShowStudentData();
  fetchAttendanceHistory();
};

function fetchAttendanceHistory() {
  const userId = localStorage.getItem("user_id");
  if (!userId) return;

  fetch(`/atm/backend/api/get_attendance.php?user_id=${userId}`)
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById("attendanceHistory");
      tbody.innerHTML = "";
      if (data.success && data.history) {
        data.history.forEach(record => {
          const tr = document.createElement("tr");
          tr.innerHTML = `<td>${record.date}</td><td>${record.status}</td>`;
          tbody.appendChild(tr);
        });
      }
    });
}
