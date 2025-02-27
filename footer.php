</div><!-- End of container -->
    
    <footer class="py-4 mt-5" style="background-color: var(--primary-bg); color: var(--text-primary);">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h4 class="mb-3">
                        <i class="bi bi-shield-fill me-2"></i>Game Armor Database
                    </h4>
                    <p class="text-muted">A comprehensive database for game armor items, weapons, and accessories.</p>
                    <div class="d-flex mt-3">
                        <a href="#" class="text-muted me-3 fs-5" title="GitHub"><i class="bi bi-github"></i></a>
                        <a href="#" class="text-muted me-3 fs-5" title="Discord"><i class="bi bi-discord"></i></a>
                        <a href="#" class="text-muted fs-5" title="Email"><i class="bi bi-envelope-fill"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links Column -->
                <div class="col-lg-8">
                    <div class="row">
                        <!-- Equipment Section -->
                        <div class="col-md-4">
                            <div class="card h-100 bg-secondary bg-opacity-25 border-0 rounded-3">
                                <div class="card-header bg-secondary bg-opacity-25 border-0 rounded-top-3">
                                    <h5 class="mb-0">
                                        <i class="bi bi-shield-fill me-2"></i>Equipment
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush bg-transparent rounded-bottom-3">
                                        <li class="list-group-item bg-transparent border-secondary">
                                            <a href="armor_list.php" class="text-decoration-none text-muted">
                                                <i class="bi bi-shield me-2"></i>Armor
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent border-secondary">
                                            <a href="weapon_list.php" class="text-decoration-none text-muted">
                                                <i class="bi bi-sword me-2"></i>Weapons
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent border-secondary">
                                            <a href="accessory_list.php" class="text-decoration-none text-muted">
                                                <i class="bi bi-gem me-2"></i>Accessories
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Character Section -->
                        <div class="col-md-4">
                            <div class="card h-100 bg-secondary bg-opacity-25 border-0 rounded-3">
                                <div class="card-header bg-secondary bg-opacity-25 border-0 rounded-top-3">
                                    <h5 class="mb-0">
                                        <i class="bi bi-people-fill me-2"></i>Characters
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush bg-transparent rounded-bottom-3">
                                        <li class="list-group-item bg-transparent border-secondary">
                                            <a href="#" class="text-decoration-none text-muted">
                                                <i class="bi bi-person-badge me-2"></i>Classes
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent border-secondary">
                                            <a href="#" class="text-decoration-none text-muted">
                                                <i class="bi bi-activity me-2"></i>Skills
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent border-secondary">
                                            <a href="#" class="text-decoration-none text-muted">
                                                <i class="bi bi-magic me-2"></i>Polymorphs
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- World Section -->
                        <div class="col-md-4">
                            <div class="card h-100 bg-secondary bg-opacity-25 border-0 rounded-3">
                                <div class="card-header bg-secondary bg-opacity-25 border-0 rounded-top-3">
                                    <h5 class="mb-0">
                                        <i class="bi bi-globe me-2"></i>World
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush bg-transparent rounded-bottom-3">
                                        <li class="list-group-item bg-transparent border-secondary">
                                            <a href="#" class="text-decoration-none text-muted">
                                                <i class="bi bi-map me-2"></i>Locations
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent border-secondary">
                                            <a href="#" class="text-decoration-none text-muted">
                                                <i class="bi bi-journal-text me-2"></i>Dungeons
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent border-secondary">
                                            <a href="view_monster.php" class="text-decoration-none text-muted">
                                                <i class="bi bi-bug me-2"></i>Monsters
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="border-secondary">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="mb-2 mb-md-0 text-muted">© <?php echo date('Y'); ?> Game Armor Database. All rights reserved.</p>
                <div>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal" class="text-muted me-3">Privacy Policy</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="text-muted">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Privacy Policy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-3" style="background-color: var(--card-bg); color: var(--text-primary);">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>This is a placeholder for the Privacy Policy content.</p>
                    <p>Normally, this would include information about how user data is collected, stored, and used.</p>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms of Service Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content rounded-3" style="background-color: var(--card-bg); color: var(--text-primary);">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title" id="termsModalLabel">Terms of Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>This is a placeholder for the Terms of Service content.</p>
                    <p>Normally, this would include the rules and guidelines for using this website and database.</p>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
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