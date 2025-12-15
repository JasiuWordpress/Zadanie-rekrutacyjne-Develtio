const register_form = document.getElementById('dl_formularz_zapisu');

if (register_form) {

    register_form.addEventListener('submit', async (event) => {

        event.preventDefault();

        const name_input  = register_form.querySelector('#dl-name');
        const email_input = register_form.querySelector('#dl-email');
        const id_input    = register_form.querySelector('#dl-post-id');
        const nonce_input = register_form.querySelector('#dl-form-nonce');
        const count = document.getElementById('current-cout');


        const formData = new FormData();
        formData.append('action', 'dl_register_form');
        formData.append('name', name_input.value);
        formData.append('email', email_input.value);
        formData.append('post_id', id_input.value);
        formData.append('nonce', nonce_input.value);

        try {
            const response = await fetch(EventRegister.ajax_url, {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (result.success) {
           
                alert('Zapisano!');

                let count_txt = count.textContent;
                let count_int = Number(count_txt);

                if(!isNaN(count_int)){
                    count_int++;
                    count.textContent =  count_int;
                }

                
                let formParent = register_form.parentElement;
                let Notification = document.createElement('h2');
                Notification.classList.add('pt-4');
                  Notification.classList.add('pb-4');
                Notification.textContent="Zapisałeś się!";
                
                register_form.reset();
                register_form.remove();
                formParent.appendChild(Notification);

               
            } else {
          
                alert(result.data || 'Błąd zapisu');
            }

        } catch (error) {
            console.error('FETCH ERROR:', error);
            alert('Błąd połączenia');
        }
    });
}
