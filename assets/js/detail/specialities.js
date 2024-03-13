if (document.getElementsByName('create_appointment')) {
    document.querySelectorAll('input.css-checkbox').forEach(i => i.addEventListener('change', function() {
        if (this.checked) {
            let already = document.querySelectorAll('input.css-checkbox:checked');
            already.forEach(e => {
                if (e !== this) {
                    e.checked = false;
                }
            })

            document.getElementById('create_appointment[speciality]').value = this.value;
            console.log(this.value);
        }
    }))
}
