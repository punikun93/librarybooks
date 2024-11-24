<script>
    (function() {
        // Calculate return date max (7 days from borrow date)
        const calculateMaxReturnDate = (date) => {
            const result = new Date(date);
            result.setDate(result.getDate() + 7);
            return result.toISOString().split('T')[0];
        };

        // Initialize date inputs
        const initializeDateInputs = () => {
            document.querySelectorAll('input[name="TanggalPeminjaman"]').forEach((borrowInput, index) => {
                const returnInput = document.querySelectorAll('input[name="TanggalPengembalian"]')[
                    index];
                if (!returnInput) return;

                // Update return date on borrow date change
                borrowInput.addEventListener('change', () => {
                    const borrowDate = borrowInput.value;

                    if (!borrowDate) {
                        returnInput.value = "";
                        returnInput.removeAttribute("min");
                        returnInput.removeAttribute("max");
                        return;
                    }

                    const maxDate = calculateMaxReturnDate(borrowDate);

                    returnInput.setAttribute("min",
                    borrowDate); // Minimal pengembalian sama dengan tanggal peminjaman
                    returnInput.setAttribute("max",
                    maxDate); // Maksimal pengembalian 7 hari setelah peminjaman

                    // Jika nilai saat ini di luar batas, sesuaikan
                    if (returnInput.value < borrowDate || returnInput.value > maxDate) {
                        returnInput.value = borrowDate;
                    }
                });

                // Set default values when initialized
                borrowInput.dispatchEvent(new Event("change"));
            });
        };

        // Initialize when DOM is ready
        document.readyState === "loading" ?
            document.addEventListener("DOMContentLoaded", initializeDateInputs) :
            initializeDateInputs();
    })();
</script>