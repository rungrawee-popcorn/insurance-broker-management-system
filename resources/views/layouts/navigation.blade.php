<script>
const input = document.getElementById('globalSearch');
const box = document.getElementById('searchResults');

let timeout = null;

input.addEventListener('input', function () {

    clearTimeout(timeout);

    timeout = setTimeout(() => {

        const query = this.value.trim();

        if (query.length < 2) {
            box.classList.add('hidden');
            box.innerHTML = '';
            return;
        }

        fetch(`/search?q=${query}`)
            .then(res => res.json())
            .then(data => {

                let html = '';

                /*
                |----------------------------------
                | Customers
                |----------------------------------
                */
                if (data.customers.length > 0) {
                    html += `<div class="p-2 bg-gray-100 text-xs font-bold">Customers</div>`;

                    data.customers.forEach(c => {
                        html += `
                        <a href="/customers/${c.id}"
                           class="block px-3 py-2 hover:bg-gray-100 text-sm border-b">
                            <div class="font-medium">
                                ${c.first_name} ${c.last_name}
                            </div>
                            <div class="text-xs text-gray-500">
                                ${c.phone ?? '-'}
                            </div>
                        </a>`;
                    });
                }

                /*
                |----------------------------------
                | Companies
                |----------------------------------
                */
                if (data.companies.length > 0) {
                    html += `<div class="p-2 bg-gray-100 text-xs font-bold">Companies</div>`;

                    data.companies.forEach(c => {
                        html += `
                        <a href="/companies/${c.id}"
                           class="block px-3 py-2 hover:bg-gray-100 text-sm border-b">
                            <div class="font-medium">
                                ${c.name}
                            </div>
                            <div class="text-xs text-gray-500">
                                ${c.code ?? '-'}
                            </div>
                        </a>`;
                    });
                }

                /*
                |----------------------------------
                | Policies
                |----------------------------------
                */
                if (data.policies.length > 0) {
                    html += `<div class="p-2 bg-gray-100 text-xs font-bold">Policies</div>`;

                    data.policies.forEach(p => {
                        html += `
                        <a href="/policies/${p.id}"
                           class="block px-3 py-2 hover:bg-gray-100 text-sm border-b">
                            <div class="font-medium">
                                ${p.policy_number}
                            </div>
                            <div class="text-xs text-gray-500">
                                Status: ${p.status ?? '-'}
                            </div>
                        </a>`;
                    });
                }

                if (html === '') {
                    html = `<div class="p-3 text-sm text-gray-500">No results found</div>`;
                }

                box.innerHTML = html;
                box.classList.remove('hidden');
            });

    }, 300);
});

/*
|----------------------------------
| Click outside to close dropdown
|----------------------------------
*/
document.addEventListener('click', function (e) {
    if (!box.contains(e.target) && e.target !== input) {
        box.classList.add('hidden');
    }
});
</script>