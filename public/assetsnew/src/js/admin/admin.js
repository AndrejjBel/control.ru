import AirDatepicker from 'air-datepicker';

function airDatepickerInputs(className) {
    const inputs = document.querySelectorAll(className);
    inputs.forEach((input) => {
        let startDate = new Date(input.dataset.val);
        new AirDatepicker(input, {
            startDate,
            selectedDates: [startDate],
            autoClose: true
        })
    });
}
airDatepickerInputs('input.air-datepicker-input');
