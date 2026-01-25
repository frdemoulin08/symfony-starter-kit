const toggleModal = (modal, isOpen) => {
    if (!modal) {
        return;
    }

    if (isOpen) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
    } else {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
    }
};

export const initModalToggles = () => {
    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-modal-toggle]');
        if (!trigger) {
            return;
        }

        const modalId = trigger.dataset.modalTarget || trigger.dataset.modalToggle;
        if (!modalId) {
            return;
        }

        const modal = document.getElementById(modalId);
        if (!modal) {
            return;
        }

        const deleteUrl = trigger.dataset.deleteUrl;
        const deleteToken = trigger.dataset.deleteToken;
        const deleteName = trigger.dataset.deleteName;
        const tableTarget = trigger.dataset.tableTarget || '';

        if (deleteUrl) {
            const form = modal.querySelector('[data-delete-form]');
            if (form) {
                form.action = deleteUrl;
                if (tableTarget !== '') {
                    form.dataset.tableTarget = tableTarget;
                } else {
                    delete form.dataset.tableTarget;
                }
            }
        }

        if (deleteToken) {
            const tokenField = modal.querySelector('input[name="_token"]');
            if (tokenField) {
                tokenField.value = deleteToken;
            }
        }

        if (deleteName) {
            const nameTarget = modal.querySelector('[data-delete-name]');
            if (nameTarget) {
                nameTarget.textContent = deleteName;
            }
        }

        toggleModal(modal, true);
    });

    document.addEventListener('click', (event) => {
        const hideTrigger = event.target.closest('[data-modal-hide]');
        if (!hideTrigger) {
            return;
        }

        const modalId = hideTrigger.dataset.modalHide;
        const modal = modalId ? document.getElementById(modalId) : hideTrigger.closest('[id]');
        toggleModal(modal, false);
    });

    document.addEventListener('submit', (event) => {
        const form = event.target.closest('[data-delete-form]');
        if (!form) {
            return;
        }

        const modal = form.closest('[id]');
        const tableTarget = form.dataset.tableTarget;
        const container = tableTarget
            ? document.querySelector(`[data-table-ajax="${tableTarget}"]`)
            : document.querySelector('[data-table-ajax]');

        if (!container) {
            return;
        }

        event.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                toggleModal(modal, false);
                return fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.text();
            })
            .then((html) => {
                container.innerHTML = html;
            })
            .catch(() => {
                window.location.reload();
            });
    });
};
