const truthyValues = new Set(['1', 'true', 'yes', 'on']);

const toFieldName = (key) => key.replace(/[A-Z]/g, (letter) => `_${letter.toLowerCase()}`);

const getField = (form, fieldName) => form.elements[fieldName] ?? form.querySelector(`[name="${fieldName}"]`);

const refreshAssigneeOptions = async (form) => {
    const sourceUrl = form.dataset.assigneeSource;
    const select = form.querySelector('select[name="assigned_to"]');

    if (!sourceUrl || !select) {
        return;
    }

    const selectedValue = select.value;

    try {
        const response = await fetch(sourceUrl, {
            headers: {
                Accept: 'application/json',
            },
        });

        if (!response.ok) {
            return;
        }

        const data = await response.json();
        const housekeepers = Array.isArray(data.housekeepers) ? data.housekeepers : [];

        select.innerHTML = '';

        housekeepers.forEach((housekeeper) => {
            const option = document.createElement('option');
            option.value = String(housekeeper.id);
            option.textContent = housekeeper.name;
            select.appendChild(option);
        });

        if (selectedValue) {
            select.value = String(selectedValue);
        }
    } catch (error) {
        console.error('Unable to refresh assignee options.', error);
    }
};

const refreshAllAssigneeOptions = async () => {
    const forms = document.querySelectorAll('[data-assignee-source]');
    await Promise.all(Array.from(forms, (form) => refreshAssigneeOptions(form)));
};

const setFieldValue = (field, value) => {
    if (!field) {
        return;
    }

    if (field.type === 'checkbox') {
        field.checked = truthyValues.has(String(value).toLowerCase());
        return;
    }

    if (field.type === 'radio') {
        const radios = field.form?.querySelectorAll(`[name="${field.name}"]`) ?? [];
        radios.forEach((radio) => {
            radio.checked = String(radio.value) === String(value);
        });
        return;
    }

    field.value = value ?? '';
};

const openModal = (modal, form = null) => {
    modal.classList.add('is-open');

    if (!form) {
        return;
    }

    form.reset();

    if (form.dataset.defaultAction) {
        form.action = form.dataset.defaultAction;
    }

    const methodField = form.querySelector('input[name="_method"]');
    if (methodField) {
        methodField.value = '';
    }
};

const closeModal = (modal) => {
    modal.classList.remove('is-open');
};

document.addEventListener('click', async (event) => {
    const openTrigger = event.target.closest('[data-modal-open]');

    if (openTrigger) {
        event.preventDefault();

        const modal = document.getElementById(openTrigger.dataset.modalOpen);
        if (!modal) {
            return;
        }

        const form = modal.querySelector('[data-modal-form]');
        openModal(modal, form);

        if (!form) {
            return;
        }

        await refreshAssigneeOptions(form);

        if (openTrigger.dataset.modalAction) {
            form.action = openTrigger.dataset.modalAction;
        }

        const methodField = form.querySelector('input[name="_method"]');
        if (methodField && openTrigger.dataset.modalMethod) {
            methodField.value = openTrigger.dataset.modalMethod;
        }

        Object.entries(openTrigger.dataset).forEach(([key, value]) => {
            if (['modalOpen', 'modalAction', 'modalMethod'].includes(key)) {
                return;
            }

            const field = getField(form, toFieldName(key));
            setFieldValue(field, value);
        });

        return;
    }

    const closeTrigger = event.target.closest('[data-modal-close]');
    if (closeTrigger) {
        const modal = closeTrigger.closest('.admin-modal');
        if (modal) {
            closeModal(modal);
        }
        return;
    }

    if (event.target.classList.contains('admin-modal') && event.target.classList.contains('is-open')) {
        closeModal(event.target);
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        document.querySelectorAll('.admin-modal.is-open').forEach(closeModal);
    }
});

window.addEventListener('storage', (event) => {
    if (event.key === 'housekeepers-changed') {
        refreshAllAssigneeOptions();
    }
});

window.addEventListener('housekeepers-changed', () => {
    refreshAllAssigneeOptions();
});
