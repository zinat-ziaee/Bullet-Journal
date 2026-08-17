function initJalaliDatePicker() {
  if (typeof jalaliDatepicker === 'undefined') {
      console.error('jalaliDatepicker is NOT loaded');
      return;
  }

  jalaliDatepicker.startWatch({
      time: false,
      separatorChars: {
          date: '-',
          between: ' ',
          time: ':'
      },
      persianDigits: true,
      useDropDownYears: true,
      autoShow: true,
      hideAfterChange: true,
      zIndex: 1060
  });
}

$(document).on('change', 'input.datetimepicker', function () {
  this.value = toPersian(this.value);
});

function toPersian(str) {
  return str.replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
}