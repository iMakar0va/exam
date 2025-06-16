document
  .querySelectorAll('input[type="radio"][name^="status_"]')
  .forEach((radio) => {
    radio.addEventListener("change", function () {
      const card = this.closest(".card");
      const saveButton = card.querySelector("#change_status");
      saveButton.style.display = "block";

      if (this.value == "отменено") {
        const reasonInput = card.querySelector("#reason-input");
        reasonInput.style.display = "block";
      } else {
        const reasonInput = card.querySelector("#reason-input");
        reasonInput.style.display = "none";
      }
    });
  });
document.querySelectorAll("#change_status").forEach((button) => {
  button.style.display = "none";

  button.addEventListener("click", function (e) {
    const card = this.closest(".card");
    const applicationId = card.dataset.id;
    const selectedStatus = card.querySelector(
      'input[type="radio"][name^="status_"]:checked'
    ).value;

    let comment = "";
    if (selectedStatus == "отменено") {
      comment = card.querySelector("#reason-input").value;
      if (!comment) {
        alert("Причина пуста!");
        return;
      }
    }

    fetch("php/update_status.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        application_id: applicationId,
        status: selectedStatus,
        comment: comment,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Статус обновлен");
          const reason = card.querySelector("#reason-input");
          reason.style.display = "none";
          card.querySelector(".status").innerHTML =
            "<b>Текущий статус: </b>" + selectedStatus;
          this.style.display = "none";
        } else {
          alert("Ошибка при обновлении статуса: " + data.error);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Произошла ошибка при отправке данных");
      });
  });
});
