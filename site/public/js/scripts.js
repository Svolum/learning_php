document.querySelector('select[name="type"]').addEventListener('change', function() {
    if (this.value === 'new') {
        let newType = prompt('Введите новый тип:', '');
        if (newType !== null) {
            newType = newType.trim().toLowerCase();
            if (newType !== '') {
                const select = this;
                const newOption = document.createElement('option');
                newOption.value = newType;
                newOption.text = newType;
                select.add(newOption);
                select.value = newType;
                console.log('Добавлен новый тип:', newType);
            } else {
                this.value = '';
                console.log('Отмена или пустой ввод');
            }
        } else {
            this.value = '';
            console.log('Отмена или пустой ввод');
        }
    }
});
