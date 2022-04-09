window.onload = () => {
  const amountButtons = document.querySelectorAll("#amount .amount-input");
  const customInput = document.querySelector("#custom_input");
  const customRadio = document.querySelector("#amount #custom_huf");
  for (const btn of amountButtons) {
    btn.addEventListener("input", () => {
      if (btn.id === "custom_huf") {
        customInput.style.display = "flex";
      } else {
        customInput.style.display = "none";
      }
    });
  }

  customInput.addEventListener("input", (change) => {
    customRadio.value = change.target.value;
  });
};
