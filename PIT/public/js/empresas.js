document.addEventListener('DOMContentLoaded', function() {
    // Adicionar confirmação antes de candidatar-se
    const forms = document.querySelectorAll('form[action*="candidatar"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const empresaNome = this.closest('.empresa-card').querySelector('h3').textContent;
            
            if (!confirm(`Tem certeza que deseja se candidatar à empresa "${empresaNome}"?`)) {
                e.preventDefault();
            }
        });
    });

    // Adicionar efeito de loading nos botões
    const buttons = document.querySelectorAll('button[type="submit"]');
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const originalText = this.textContent;
            this.textContent = 'Enviando...';
            this.disabled = true;
            
            // Reabilitar o botão após 3 segundos (caso algo dê errado)
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
            }, 3000);
        });
    });

    // Auto-hide alerts após 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Adicionar animação de entrada nos cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});