<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize dates
        const borrowDate = document.getElementById('borrowDate');
        const returnDate = document.getElementById('returnDate');
    
        // Get today's date in local timezone
        const today = new Date();
        const localToday = new Date(today.getTime() - today.getTimezoneOffset() * 60 * 1000)
            .toISOString().split('T')[0];
        
        // Set default borrow date
        borrowDate.value = localToday;
    
        // Update min and max for returnDate based on borrowDate
        const updateReturnDateLimits = () => {
            const selectedDate = new Date(borrowDate.value);
    
            // Calculate min and max return dates
            const minReturnDate = selectedDate.toISOString().split('T')[0];
            const maxReturnDate = new Date(selectedDate.getTime() + 7 * 24 * 60 * 60 * 1000)
                .toISOString().split('T')[0];
    
            // Set attributes for returnDate
            returnDate.min = minReturnDate;
            returnDate.max = maxReturnDate;
    
            // Adjust returnDate value if it falls outside the range
            if (returnDate.value < minReturnDate || returnDate.value > maxReturnDate) {
                returnDate.value = minReturnDate;
            }
        };
    
        // Initialize limits on page load
        updateReturnDateLimits();
    
        // Update limits whenever borrowDate changes
        borrowDate.addEventListener('change', updateReturnDateLimits);
    });
    </script>
    