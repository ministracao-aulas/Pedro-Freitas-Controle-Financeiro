
window.bill_actions = {
    deleteBill: (billId) => {
        let modalBillIdInput = document.querySelector('#deleteBillModal input[name="bill_id"]')
        let deleteModalMessage = document.querySelector('#deleteBillModal [data-modal-message]')

        if (!modalBillIdInput) {
            return;
        }

        if (deleteModalMessage) {
            deleteModalMessage.innerHTML = `Deseja realmente excluir o item <strong>${billId}</strong>?`
        }

        modalBillIdInput.value = billId;

        try {
            jQuery('#showBillModal').modal('hide');
            jQuery('#editBillModal').modal('hide');
        } catch (error) {
            console.log(error);
        }

        jQuery('#deleteBillModal').modal('show');

        $('#deleteBillModal').on('hidden.bs.modal', function (event) {
            modalBillIdInput.value = ''

            if (deleteModalMessage) {
                deleteModalMessage.innerHTML = ''
            }
        })
    },
    editBill: (billId) => {
        if (!billId) {
            console.log('Error: Invalid billId', billId)
            return
        }

        let row = document.querySelector(`[data-bill-row-id="${billId}"]`)

        if (!row) {
            console.log('Error: Invalid row', row)
            return
        }

        let modalBillIdInput = document.querySelector('#editBillModal input[name="bill_id"]')
        let modalMessage = document.querySelector('#editBillModal [data-modal-message]')

        if (!modalBillIdInput) {
            return;
        }

        modalBillIdInput.value = billId

        let rowData = (() => {
            try {
                return JSON.parse(row.dataset.billRowData)
            } catch (error) {
                console.error(error)
                return null
            }
        })()

        if (!rowData) {
            console.log('Error: invalid rowData', rowData)
            return
        }

        let inputsAndKeys = [
            {
                selector: 'select[name="status"]',
                key: 'status',
            },
            {
                selector: 'select[name="type"]',
                key: 'type',
            },
            {
                selector: 'input[name="title"]',
                key: 'title',
            },
            {
                selector: 'input[name="overdue_date"]',
                key: 'overdue_date',
                formater: (input, value, rowData) => {
                    try {
                        return (new Date(value)).toISOString().slice(0, 10)
                    } catch (error) {
                        console.error('Error on overdue_date', error, 'value:', value)
                        return value
                    }
                }
            },
            {
                selector: 'input[name="value"]',
                key: 'value',
                formater: (input, value, rowData) => {
                    console.log(input, value)

                    return value
                }
            },
            {
                selector: 'input[name="creditor_id"]',
                key: 'creditor_id',
            },
            {
                selector: 'input[data-null-name="creditor_name"]',
                key: 'creditor',
                formater: (input, value, rowData) => {
                    if (!window.DotObject || !window.DotObject.get) {
                        return
                    }

                    return DotObject.get('name', value)
                }
            },
            {
                selector: 'textarea[name="note"]',
                key: 'note',
            },
        ]

        let fillInputs = (clear = false) => {
            inputsAndKeys.forEach(inputInfo => {
                if (!inputInfo || !inputInfo.selector) {
                    return
                }

                let input = document.querySelector(inputInfo.selector)

                if (!input) {
                    return
                }

                let isEmptyValue = (clear || !inputInfo.key)

                let formater = inputInfo.formater

                let valueToSet = isEmptyValue ? '' : rowData[inputInfo.key]

                if (!isEmptyValue && formater) {
                    valueToSet = formater(input, valueToSet, rowData)
                }

                input.value =  valueToSet

                input.dispatchEvent(
                    new Event("change")
                )
            })
        }

        fillInputs(true);

        try {
            jQuery('#showBillModal').modal('hide');
            jQuery('#deleteBillModal').modal('hide');
        } catch (error) {
            console.log(error);
        }

        jQuery('#editBillModal').on('show.bs.modal', function (event) {
            modalBillIdInput.value = billId
            fillInputs()

            if (modalMessage) {
                modalMessage.innerHTML = `Editando item <strong>#${billId}</strong>`
            }
        })

        jQuery('#editBillModal').on('hidden.bs.modal', function (event) {
            modalBillIdInput.value = ''
            fillInputs(true)

            if (modalMessage) {
                modalMessage.innerHTML = ''
            }
        })

        jQuery('#editBillModal').modal('show');
    },
    showBill: (billId) => {
        if (!billId) {
            console.log('Error: Invalid billId', billId)
            return
        }

        let modalContainer = document.querySelector('#showBillModal')

        if (!modalContainer) {
            console.log('Error: Invalid modalContainer', modalContainer)
            return
        }

        let row = document.querySelector(`[data-bill-row-id="${billId}"]`)

        if (!row) {
            console.log('Error: Invalid row', row)
            return
        }

        let rowData = (() => {
            try {
                return JSON.parse(row.dataset.billRowData)
            } catch (error) {
                console.error(error)
                return null
            }
        })()

        if (!rowData) {
            console.log('Error: invalid rowData', rowData)
            return
        }

        let infoItems = [
            {
                selector: '[data-show-name="id"]',
                key: 'id',
            },
            {
                selector: '[data-show-name="status"]',
                key: 'status',
            },
            {
                selector: '[data-show-name="type"]',
                key: 'type',
            },
            {
                selector: '[data-show-name="title"]',
                key: 'title',
            },
            {
                selector: '[data-show-name="overdue_date"]',
                key: 'overdue_date',
                formater: (input, value, rowData) => {
                    try {
                        return (new Date(value)).toISOString().slice(0, 10)
                    } catch (error) {
                        console.error('Error on overdue_date', error, 'value:', value)
                        return value
                    }
                }
            },
            {
                selector: '[data-show-name="value"]',
                key: 'value',
                formater: (input, value, rowData) => {
                    console.log(input, value)

                    return value
                }
            },
            {
                selector: '[data-show-name="creditor_id"]',
                key: 'creditor_id',
            },
            {
                selector: '[data-show-name="creditor_name"]',
                key: 'creditor',
                formater: (input, value, rowData) => {
                    if (!window.DotObject || !window.DotObject.get) {
                        return
                    }

                    return DotObject.get('name', value)
                }
            },
            {
                selector: '[data-show-name="note"]',
                key: 'note',
            },
        ]

        let updateModalInfo = (clear = false) => {
            infoItems.forEach(inputInfo => {
                if (!inputInfo || !inputInfo.selector) {
                    return
                }

                let elements = modalContainer.querySelectorAll(inputInfo.selector)

                if (!elements || !elements.length) {
                    return
                }

                let isEmptyValue = (clear || !inputInfo.key)

                let formater = inputInfo.formater

                let valueToSet = isEmptyValue ? '' : rowData[inputInfo.key]

                elements.forEach(element => {
                    if (!isEmptyValue && formater) {
                        valueToSet = formater(element, valueToSet, rowData)
                    }

                    element.innerHTML = valueToSet

                    element.dispatchEvent(
                        new Event("change")
                    )
                })
            })
        }

        updateModalInfo(true);

        let modalMessage = document.querySelector('#showBillModal [data-modal-message]')

        jQuery('#showBillModal').on('show.bs.modal', function (event) {
            updateModalInfo()

            if (modalMessage) {
                modalMessage.innerHTML = `Detalhes da conta <strong>#${billId}</strong>`
            }
        })

        jQuery('#showBillModal').on('hidden.bs.modal', function (event) {
            updateModalInfo(true)

            if (modalMessage) {
                modalMessage.innerHTML = ''
            }
        })

        jQuery('#showBillModal').modal('show');
    },
}

window.addEventListener('load', (event) => {
    if (window.bill_actions && window.deleteId) {
        window.bill_actions.deleteBill(window.deleteId);
    }

    initSearch && initSearch();
});
