document.getElementById("regForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
  const fields = form.querySelectorAll("input");
  const formData = new FormData(form);

  let isValid = true;
  let errors = [];

  fields.forEach((el) => {
    el.classList.remove("error");
  });
  document.getElementById("errorMessage").textContent = "";

  const namePattern = /^[А-Яа-яЁё\s]+$/;
  const phonePattern = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/;
  const emailPattern = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;

  const lastName = form.last_name.value.trim();
  const firstName = form.first_name.value.trim();
  const fatherName = form.father_name.value.trim();
  const phone = form.phone.value.trim();
  const email = form.email.value.trim();
  const login = form.login.value.trim();
  const password = form.password.value.trim();

  if (!namePattern.test(lastName) || !lastName) {
    errors.push("Введите корректную фамилию");
    form.last_name.classList.add("error");
    isValid = false;
  }
  if (!namePattern.test(firstName) || !firstName) {
    errors.push("Введите корректное имя");
    form.first_name.classList.add("error");
    isValid = false;
  }
  if (!namePattern.test(fatherName) || !fatherName) {
    errors.push("Введите корректное отчество");
    form.father_name.classList.add("error");
    isValid = false;
  }
  if (!phonePattern.test(phone) || !phone) {
    errors.push("Введите корректный номер телефона");
    form.phone.classList.add("error");
    isValid = false;
  }
  if (!emailPattern.test(email) || !email) {
    errors.push("Введите корректную почту");
    form.email.classList.add("error");
    isValid = false;
  }
  if (!login) {
    errors.push("Введите логин");
    form.login.classList.add("error");
    isValid = false;
  }
  if (password.length < 6 || !password) {
    errors.push("Введите пароль длиной неменьше 6 символов");
    form.password.classList.add("error");
    isValid = false;
  }
  if (!isValid) {
    document.getElementById("errorMessage").innerHTML = errors.join("<br>");
    return;
  }

  fetch("php/insert_user.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Вы зарегистрировались в системе!");
        window.location.href = "auth.php";
      } else {
        document.getElementById("errorMessage").innerHTML = data.message;
        if (data.message == "Такой логин уже есть") {
          form.login.classList.add("error");
        }
      }
    })
    .catch((error) => {
      document.getElementById("errorMessage").innerHTML = error.message;
    });
});
