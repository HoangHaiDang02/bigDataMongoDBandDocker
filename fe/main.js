const stepMenuOne = document.querySelector(".formbold-step-menu1");
const stepMenuTwo = document.querySelector(".formbold-step-menu2");
const stepMenuThree = document.querySelector(".formbold-step-menu3");

const stepOne = document.querySelector(".formbold-form-step-1");
const stepTwo = document.querySelector(".formbold-form-step-2");
const stepThree = document.querySelector(".formbold-form-step-3");

const formSubmitBtn = document.querySelector(".formbold-btn");
const formBackBtn = document.querySelector(".formbold-back-btn");

const toan1 = document.querySelector("#toan1");
const van1 = document.querySelector("#van1");
const anh1 = document.querySelector("#anh1");
const ly1 = document.querySelector("#ly1");
const hoa1 = document.querySelector("#hoa1");
const sinh1 = document.querySelector("#sinh1");
const dia1 = document.querySelector("#dia1");
const su1 = document.querySelector("#su1");
const toan2 = document.querySelector("#toan2");
const van2 = document.querySelector("#van2");
const anh2 = document.querySelector("#anh2");
const ly2 = document.querySelector("#ly2");
const hoa2 = document.querySelector("#hoa2");
const sinh2 = document.querySelector("#sinh2");
const dia2 = document.querySelector("#dia2");
const su2 = document.querySelector("#su2");

function validateInputScore(values) {
  return values.every((value) => {
    return value >= 0 && value <= 10;
  });
}

formSubmitBtn.addEventListener("click", function (event) {
  event.preventDefault();
  if (stepMenuOne.className == "formbold-step-menu1 active") {
    event.preventDefault();
    const arrValuesInputScore = [
      Number(toan1?.value),
      Number(ly1?.value),
      Number(hoa1?.value),
      Number(sinh1?.value),
      Number(van1?.value),
      Number(su1?.value),
      Number(dia1?.value),
      Number(anh1?.value),
    ];
    if (validateInputScore(arrValuesInputScore)) {
      stepMenuOne.classList.remove("active");
      stepMenuTwo.classList.add("active");

      stepOne.classList.remove("active");
      stepTwo.classList.add("active");
      formSubmitBtn.textContent = "Submit";
      formBackBtn.classList.add("active");
    } else {
      alert("Fail");
    }

    formBackBtn.addEventListener("click", function (event) {
      event.preventDefault();

      const arrValuesInputScore = [
        Number(toan2?.value),
        Number(ly2?.value),
        Number(hoa2?.value),
        Number(sinh2?.value),
        Number(van2?.value),
        Number(su2?.value),
        Number(dia2?.value),
        Number(anh2?.value),
      ];

      if (validateInputScore(arrValuesInputScore)) {
        stepMenuOne.classList.add("active");
        stepMenuTwo.classList.remove("active");

        stepOne.classList.add("active");
        stepTwo.classList.remove("active");
        formSubmitBtn.textContent = "Next";
        formBackBtn.classList.remove("active");
      }
    });
  } else if (stepMenuTwo.className == "formbold-step-menu2 active") {
    event.preventDefault();

    stepMenuTwo.classList.remove("active");
    stepMenuThree.classList.add("active");

    stepTwo.classList.remove("active");
    stepThree.classList.add("active");
    formSubmitBtn.textContent = "Done!";

    formBackBtn.classList.remove("active");
  } else if (stepMenuThree.className == "formbold-step-menu3 active") {
    document.querySelector("form").submit();
  }
});