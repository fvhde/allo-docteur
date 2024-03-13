if (document.getElementsByName('create_appointment')) {
    document.querySelectorAll('input.css-radio').forEach(i => i.addEventListener('change', function(e) {
        let item = e.target.value;
        console.log(item);
        document.getElementById('create_appointment[time]').value = item;
    }))
}