document.getElementById("authForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
  const fields = form.querySelectorAll("input");
  const formData = new FormData(form);

  let isValid = true;
  let errors = [];

  fields.forEach((element) => {
    element.classList.remove("error");
  });
  document.getElementById("errorMessage").textContent = "";

  const login = form.login.value.trim();
  const password = form.password.value.trim();

  if (!login) {
    errors.push("Введите логин");
    form.login.classList.add("error");
    isValid = false;
  }
  if (!password) {
    errors.push("Введите пароль");
    form.password.classList.add("error");
    isValid = false;
  }
  if (!isValid) {
    document.getElementById("errorMessage").innerHTML = errors.join("<br>");
    return;
  }

  fetch("php/login.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        if (data.message == "Админ") {
          window.location.href = "admin.php";
        } else {
          window.location.href = "lk.php";
        }
      } else {
        document.getElementById("errorMessage").innerHTML = data.message;
        if (data.message == "Неверный логин") {
          form.login.classList.add("error");
        }
        if (data.message == "Неверный пароль") {
          form.password.classList.add("error");
        }
      }
    })
    .catch((error) => {
      document.getElementById("errorMessage").innerHTML = error.message;
    });
});
