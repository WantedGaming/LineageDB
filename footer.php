</div><!-- End of container -->
    
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-shield-fill me-2"></i>Game Armor Database</h5>
                    <p class="text-muted">A comprehensive management system for game armor items.</p>
                </div>
                <div class="col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-decoration-none text-muted">Armor List</a></li>
                        <li><a href="add_armor.php" class="text-decoration-none text-muted">Add New Armor</a></li>
                        <li><a href="stats.php" class="text-decoration-none text-muted">Statistics</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Resources</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted">Documentation</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">API</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Support</a></li>
                    </ul>
                </div>
            </div>
            <hr class="mt-3 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0 text-muted">© <?php echo date('Y'); ?> Game Armor Database. All rights reserved.</p>
                <div>
                    <a href="#" class="text-muted me-3"><i class="bi bi-github"></i></a>
                    <a href="#" class="text-muted me-3"><i class="bi bi-discord"></i></a>
                    <a href="#" class="text-muted"><i class="bi bi-envelope-fill"></i></a>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const htmlElement = document.documentElement;
            
            themeToggle.addEventListener('change', function() {
                if(this.checked) {
                    htmlElement.setAttribute('data-bs-theme', 'dark');
                    document.querySelector('.theme-switch-wrapper span').textContent = 'Dark';
                } else {
                    htmlElement.setAttribute('data-bs-theme', 'light');
                    document.querySelector('.theme-switch-wrapper span').textContent = 'Light';
                }
            });
        });
    </script>
</body>
</html>