fetch('stripe-key.php')
    .then(function (res) {
        return res.json()
    })
    .then(function (keys) {
        const { publishableKey } = keys
        const stripe = Stripe(publishableKey)
        const elements = stripe.elements()

        const style = {
            base: {
                color: '#fff'
            }
        }

        const card = elements.create('card', { style })
        card.mount('#card-element')

        const payForm = document.querySelector('#pay-form')
        const errorEl = document.querySelector('#card-errors')

        const stripeTokenHandler = token => {
            const hiddenInput = document.createElement('input')
            hiddenInput.setAttribute('type', 'hidden')
            hiddenInput.setAttribute('name', 'stripeToken')
            hiddenInput.setAttribute('value', token.id)
            payForm.appendChild(hiddenInput)
            payForm.submit()
        }

        payForm.addEventListener('submit', evt => {
            evt.preventDefault()
            stripe.createToken(card).then(res => {
                if (res.error) errorEl.textContent = res.error.message
                else stripeTokenHandler(res.token)
            })
        })
    })