document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.profile-nav li');
    const contentArea = document.querySelector('.profile-content');
    const personalDataContent = contentArea.innerHTML;

    // Education content template
    const educationContent = `
        <div class="profile-content">
            <div class="content-header">
                <h2>Education</h2>
                <p>Add your educational background</p>
            </div>

            <div class="education-list">
                <!-- Education Item Example -->
                <div class="education-item">
                    <div class="education-header">
                        <div class="education-info">
                            <h3>Bachelor's Degree</h3>
                            <p class="institution">Universitas Indonesia</p>
                            <p class="major">Computer Science</p>
                        </div>
                        <div class="education-actions">
                            <button class="edit-btn"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="education-details">
                        <p class="gpa"><i class="fas fa-star"></i> GPA: 3.75</p>
                    </div>
                </div>
            </div>

            <button class="add-btn">
                <i class="fas fa-plus"></i> Add Education
            </button>

            <!-- Add/Edit Education Modal -->
            <div class="modal" id="educationModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Add Education</h3>
                        <button class="close-modal"><i class="fas fa-times"></i></button>
                    </div>
                    <form class="education-form">
                        <div class="form-section">
                            <div class="form-group">
                                <label>Education Level*</label>
                                <select name="level" required>
                                    <option value="">Select education level</option>
                                    <option value="High School (SMA/SMK)">High School (SMA/SMK)</option>
                                    <option value="Diploma (D3)">Diploma (D3)</option>
                                    <option value="Diploma (D4)">Diploma (D4)</option>
                                    <option value="Bachelor's Degree (S1)">Bachelor's Degree (S1)</option>
                                    <option value="Master's Degree (S2)">Master's Degree (S2)</option>
                                    <option value="Doctorate (S3)">Doctorate (S3)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Institution Name*</label>
                                <input type="text" name="institution" placeholder="Enter institution name" required>
                            </div>

                            <div class="form-group">
                                <label>Major/Field of Study*</label>
                                <input type="text" name="major" placeholder="Enter your major" required>
                            </div>

                            <div class="form-group">
                                <label>GPA/IPK*</label>
                                <input type="number" name="gpa" step="0.01" min="0" max="4" 
                                    placeholder="Enter your GPA (e.g., 3.50)" required>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="cancel-btn">Cancel</button>
                            <button type="submit" class="save-btn">Save Education</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

    // Tambahkan template konten work experience
    const workExperienceContent = `
        <div class="profile-content">
            <div class="content-header">
                <h2>Work Experience</h2>
                <p>Add your work experience information</p>
            </div>

            <div class="experience-list">
                <!-- Work Experience Item Example -->
                <div class="experience-item">
                    <div class="experience-header">
                        <div class="experience-info">
                            <h3>Software Engineer</h3>
                            <p class="company">PT Teknologi Indonesia</p>
                            <p class="period"><i class="far fa-calendar-alt"></i> Jan 2020 - Present</p>
                            <p class="location"><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</p>
                        </div>
                        <div class="experience-actions">
                            <button class="edit-btn"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="experience-details">
                        <p class="description">• Developed and maintained web applications using React.js and Node.js</p>
                        <p class="description">• Collaborated with cross-functional teams to deliver high-quality software solutions</p>
                    </div>
                </div>
            </div>

            <button class="add-btn">
                <i class="fas fa-plus"></i> Add Work Experience
            </button>

            <!-- Add/Edit Work Experience Modal -->
            <div class="modal" id="workModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Add Work Experience</h3>
                        <button class="close-modal"><i class="fas fa-times"></i></button>
                    </div>
                    <form class="work-form">
                        <div class="form-section">
                            <div class="form-group">
                                <label>Job Title*</label>
                                <input type="text" name="title" placeholder="Enter your job title" required>
                            </div>

                            <div class="form-group">
                                <label>Company Name*</label>
                                <input type="text" name="company" placeholder="Enter company name" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Start Date*</label>
                                    <input type="month" name="startDate" required>
                                </div>
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="month" name="endDate">
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="currentJob" name="currentJob">
                                        <label for="currentJob">I currently work here</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Location*</label>
                                <input type="text" name="location" placeholder="Enter work location" required>
                            </div>

                            <div class="form-group">
                                <label>Job Description*</label>
                                <textarea name="description" placeholder="Describe your responsibilities and achievements" required></textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="cancel-btn">Cancel</button>
                            <button type="submit" class="save-btn">Save Experience</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

    // Tambahkan template konten skills & certifications
    const skillsContent = `
        <div class="profile-content">
            <div class="content-header">
                <h2>Skills & Certifications</h2>
                <p>Add your skills and professional certifications</p>
            </div>

            <!-- Skills Section -->
            <div class="skills-section">
                <div class="section-header">
                    <h3>Skills</h3>
                    <button class="add-skill-btn" id="addSkillBtn">
                        <i class="fas fa-plus"></i> Add Skill
                    </button>
                </div>
                
                <div class="skills-list">
                    <div class="skill-item">
                        <div class="skill-info">
                            <h4>JavaScript</h4>
                            <p class="skill-level">Advanced</p>
                        </div>
                        <div class="skill-actions">
                            <button class="edit-btn"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certifications Section -->
            <div class="certifications-section">
                <div class="section-header">
                    <h3>Certifications</h3>
                    <button class="add-cert-btn" id="addCertBtn">
                        <i class="fas fa-plus"></i> Add Certification
                    </button>
                </div>
                
                <div class="certifications-list">
                    <div class="cert-item">
                        <div class="cert-info">
                            <h4>AWS Certified Solutions Architect</h4>
                            <p class="issuer">Amazon Web Services (AWS)</p>
                            <p class="cert-date"><i class="far fa-calendar-alt"></i> Issued Jan 2023 · Expires Jan 2026</p>
                            <p class="cert-id"><i class="fas fa-certificate"></i> Credential ID: AWS-123456</p>
                        </div>
                        <div class="cert-actions">
                            <button class="edit-btn"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add/Edit Skill Modal -->
            <div class="modal" id="skillModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Add Skill</h3>
                        <button class="close-modal"><i class="fas fa-times"></i></button>
                    </div>
                    <form class="skill-form">
                        <div class="form-section">
                            <div class="form-group">
                                <label>Skill Name*</label>
                                <input type="text" name="skillName" placeholder="Enter skill name" required>
                            </div>

                            <div class="form-group">
                                <label>Proficiency Level*</label>
                                <select name="skillLevel" required>
                                    <option value="">Select level</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert">Expert</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="cancel-btn">Cancel</button>
                            <button type="submit" class="save-btn">Save Skill</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add/Edit Certification Modal -->
            <div class="modal" id="certModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Add Certification</h3>
                        <button class="close-modal"><i class="fas fa-times"></i></button>
                    </div>
                    <form class="cert-form">
                        <div class="form-section">
                            <div class="form-group">
                                <label>Certification Name*</label>
                                <input type="text" name="certName" placeholder="Enter certification name" required>
                            </div>

                            <div class="form-group">
                                <label>Issuing Organization*</label>
                                <input type="text" name="issuer" placeholder="Enter issuing organization" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Issue Date*</label>
                                    <input type="month" name="issueDate" required>
                                </div>
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="month" name="expiryDate">
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="noExpiry" name="noExpiry">
                                        <label for="noExpiry">No expiration date</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Credential ID</label>
                                <input type="text" name="credentialId" placeholder="Enter credential ID">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="cancel-btn">Cancel</button>
                            <button type="submit" class="save-btn">Save Certification</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

    // Tambahkan template konten documents
    const documentsContent = `
        <div class="profile-content">
            <div class="content-header">
                <h2>Documents</h2>
                <p>Upload your important documents</p>
            </div>

            <div class="documents-section">
                <!-- CV Document -->
                <div class="document-item">
                    <div class="document-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div class="document-info">
                        <h4>Curriculum Vitae (CV)</h4>
                        <p class="document-desc">Upload your latest CV in PDF format (Max. 2MB)</p>
                        <div class="file-info">
                            <span class="filename">my-cv.pdf</span>
                            <span class="filesize">1.2 MB</span>
                            <span class="upload-date">Uploaded on Jan 15, 2024</span>
                        </div>
                    </div>
                    <div class="document-actions">
                        <button class="upload-btn" data-type="cv">
                            <i class="fas fa-upload"></i> Upload New
                        </button>
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

                <!-- Certificate/Ijazah -->
                <div class="document-item">
                    <div class="document-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div class="document-info">
                        <h4>Certificate/Ijazah</h4>
                        <p class="document-desc">Upload your latest education certificate (Max. 2MB)</p>
                        <div class="upload-placeholder">
                            <p>No document uploaded yet</p>
                        </div>
                    </div>
                    <div class="document-actions">
                        <button class="upload-btn" data-type="certificate">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                    </div>
                </div>

                <!-- Portfolio -->
                <div class="document-item">
                    <div class="document-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div class="document-info">
                        <h4>Portfolio</h4>
                        <p class="document-desc">Upload your portfolio in PDF format (Max. 5MB)</p>
                        <div class="upload-placeholder">
                            <p>No document uploaded yet</p>
                        </div>
                    </div>
                    <div class="document-actions">
                        <button class="upload-btn" data-type="portfolio">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                    </div>
                </div>
            </div>

            <!-- Upload Document Modal -->
            <div class="modal" id="uploadModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Upload Document</h3>
                        <button class="close-modal"><i class="fas fa-times"></i></button>
                    </div>
                    <form class="upload-form">
                        <div class="form-section">
                            <div class="upload-area">
                                <input type="file" id="documentFile" accept=".pdf" hidden>
                                <div class="upload-box">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Drag & drop your file here or</p>
                                    <button type="button" class="browse-btn">Browse File</button>
                                </div>
                                <div class="file-preview"></div>
                            </div>
                            <p class="upload-info">Supported format: PDF only</p>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="cancel-btn">Cancel</button>
                            <button type="submit" class="save-btn">Upload Document</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            navItems.forEach(nav => nav.classList.remove('active'));
            item.classList.add('active');
            
            const section = item.querySelector('span').textContent.trim().toLowerCase();
            
            if (section === 'personal data') {
                contentArea.innerHTML = personalDataContent;
            } else if (section === 'education') {
                contentArea.innerHTML = educationContent;
                initializeEducationHandlers();
            } else if (section === 'work experience') {
                contentArea.innerHTML = workExperienceContent;
                initializeWorkHandlers();
            } else if (section === 'skills & certifications') {
                contentArea.innerHTML = skillsContent;
                initializeSkillsHandlers();
            } else if (section === 'documents') {
                contentArea.innerHTML = documentsContent;
                initializeDocumentsHandlers();
            }
        });
    });

    function initializeEducationHandlers() {
        const modal = document.getElementById('educationModal');
        const addBtn = document.querySelector('.add-btn');
        const closeBtn = document.querySelector('.close-modal');
        const cancelBtn = document.querySelector('.cancel-btn');
        const educationForm = document.querySelector('.education-form');

        if (!modal || !addBtn || !closeBtn || !cancelBtn || !educationForm) {
            console.error('Required education elements not found');
            return;
        }

        // Open modal
        addBtn.addEventListener('click', () => {
            modal.classList.add('active');
        });

        // Close modal
        const closeModal = () => {
            modal.classList.remove('active');
            educationForm.reset();
        };

        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Handle form submission
        educationForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(educationForm);
            const educationData = {
                level: formData.get('level'),
                institution: formData.get('institution'),
                major: formData.get('major'),
                gpa: formData.get('gpa')
            };

            // Add new education item to list
            const educationList = document.querySelector('.education-list');
            const newEducation = createEducationItem(educationData);
            educationList.appendChild(newEducation);
            
            closeModal();
        });

        // Handle edit and delete
        document.querySelectorAll('.education-actions button').forEach(button => {
            button.addEventListener('click', (e) => {
                const action = e.currentTarget.classList.contains('edit-btn') ? 'edit' : 'delete';
                const educationItem = e.currentTarget.closest('.education-item');
                
                if (action === 'edit') {
                    modal.classList.add('active');
                } else {
                    if (confirm('Are you sure you want to delete this education?')) {
                        educationItem.remove();
                    }
                }
            });
        });
    }

    function initializeWorkHandlers() {
        const modal = document.getElementById('workModal');
        const addBtn = document.querySelector('.add-btn');
        const closeBtn = document.querySelector('.close-modal');
        const cancelBtn = document.querySelector('.cancel-btn');
        const workForm = document.querySelector('.work-form');
        const currentJobCheckbox = document.getElementById('currentJob');
        const endDateInput = workForm.querySelector('[name="endDate"]');

        if (!modal || !addBtn || !closeBtn || !cancelBtn || !workForm) {
            console.error('Required work experience elements not found');
            return;
        }

        // Handle current job checkbox
        currentJobCheckbox?.addEventListener('change', (e) => {
            if (e.target.checked) {
                endDateInput.value = '';
                endDateInput.disabled = true;
            } else {
                endDateInput.disabled = false;
            }
        });

        // Open modal
        addBtn.addEventListener('click', () => {
            modal.classList.add('active');
        });

        // Close modal
        const closeModal = () => {
            modal.classList.remove('active');
            workForm.reset();
            endDateInput.disabled = false;
        };

        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Handle form submission
        workForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(workForm);
            const workData = {
                title: formData.get('title'),
                company: formData.get('company'),
                startDate: formatDate(formData.get('startDate')),
                endDate: formData.get('currentJob') ? 'Present' : formatDate(formData.get('endDate')),
                location: formData.get('location'),
                description: formData.get('description').split('\n')
            };

            const experienceList = document.querySelector('.experience-list');
            const newExperience = createWorkItem(workData);
            experienceList.appendChild(newExperience);
            
            closeModal();
        });

        // Handle edit and delete
        document.querySelectorAll('.experience-actions button').forEach(button => {
            button.addEventListener('click', (e) => {
                const action = e.currentTarget.classList.contains('edit-btn') ? 'edit' : 'delete';
                const experienceItem = e.currentTarget.closest('.experience-item');
                
                if (action === 'edit') {
                    modal.classList.add('active');
                } else {
                    if (confirm('Are you sure you want to delete this experience?')) {
                        experienceItem.remove();
                    }
                }
            });
        });
    }

    function initializeSkillsHandlers() {
        const skillModal = document.getElementById('skillModal');
        const certModal = document.getElementById('certModal');
        const addSkillBtn = document.getElementById('addSkillBtn');
        const addCertBtn = document.getElementById('addCertBtn');
        const noExpiryCheckbox = document.getElementById('noExpiry');
        const expiryDateInput = document.querySelector('[name="expiryDate"]');

        // Handle skill modal
        if (addSkillBtn && skillModal) {
            addSkillBtn.addEventListener('click', () => {
                skillModal.classList.add('active');
            });

            initializeModalHandlers(skillModal, '.skill-form', createSkillItem);
        }

        // Handle certification modal
        if (addCertBtn && certModal) {
            addCertBtn.addEventListener('click', () => {
                certModal.classList.add('active');
            });

            initializeModalHandlers(certModal, '.cert-form', createCertItem);
        }

        // Handle no expiry checkbox
        if (noExpiryCheckbox && expiryDateInput) {
            noExpiryCheckbox.addEventListener('change', (e) => {
                expiryDateInput.disabled = e.target.checked;
                if (e.target.checked) {
                    expiryDateInput.value = '';
                }
            });
        }
    }

    function initializeDocumentsHandlers() {
        const uploadModal = document.getElementById('uploadModal');
        const uploadBtns = document.querySelectorAll('.upload-btn');
        const fileInput = document.getElementById('documentFile');
        const browseBtn = document.querySelector('.browse-btn');
        const uploadForm = document.querySelector('.upload-form');
        const filePreview = document.querySelector('.file-preview');
        const uploadBox = document.querySelector('.upload-box');

        let currentDocType = '';

        // Handle upload button clicks
        uploadBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                currentDocType = btn.dataset.type;
                uploadModal.classList.add('active');
            });
        });

        // Handle browse button
        browseBtn?.addEventListener('click', () => {
            fileInput.click();
        });

        // Handle file selection
        fileInput?.addEventListener('change', handleFileSelect);

        // Handle drag and drop
        uploadBox?.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadBox.classList.add('dragover');
        });

        uploadBox?.addEventListener('dragleave', () => {
            uploadBox.classList.remove('dragover');
        });

        uploadBox?.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadBox.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file && file.type === 'application/pdf') {
                handleFileSelect({ target: { files: [file] } });
            }
        });

        // Initialize modal handlers
        initializeModalHandlers(uploadModal, '.upload-form', handleDocumentUpload);

        function handleFileSelect(e) {
            const file = e.target.files[0];
            if (file) {
                const maxSize = currentDocType === 'portfolio' ? 5 : 2; // MB
                if (file.size > maxSize * 1024 * 1024) {
                    alert(`File size should not exceed ${maxSize}MB`);
                    return;
                }
                showFilePreview(file);
            }
        }

        function showFilePreview(file) {
            filePreview.innerHTML = `
                <div class="preview-item">
                    <i class="fas fa-file-pdf"></i>
                    <div class="preview-info">
                        <p class="preview-name">${file.name}</p>
                        <p class="preview-size">${formatFileSize(file.size)}</p>
                    </div>
                    <button type="button" class="remove-file">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            const removeBtn = filePreview.querySelector('.remove-file');
            removeBtn?.addEventListener('click', () => {
                fileInput.value = '';
                filePreview.innerHTML = '';
            });
        }

        function handleDocumentUpload(formData) {
            // Simulate document upload
            const file = fileInput.files[0];
            if (!file) return;

            const documentItem = document.querySelector(`[data-type="${currentDocType}"]`)
                .closest('.document-item');
            
            // Update document item UI
            const fileInfo = documentItem.querySelector('.document-info');
            fileInfo.innerHTML = `
                <h4>${getDocumentTitle(currentDocType)}</h4>
                <p class="document-desc">${getDocumentDescription(currentDocType)}</p>
                <div class="file-info">
                    <span class="filename">${file.name}</span>
                    <span class="filesize">${formatFileSize(file.size)}</span>
                    <span class="upload-date">Uploaded on ${formatDate(new Date())}</span>
                </div>
            `;

            // Update actions
            const actions = documentItem.querySelector('.document-actions');
            actions.innerHTML = `
                <button class="upload-btn" data-type="${currentDocType}">
                    <i class="fas fa-upload"></i> Upload New
                </button>
                <button class="delete-btn"><i class="fas fa-trash"></i></button>
            `;

            // Reinitialize handlers
            initializeDocumentsHandlers();
        }
    }

    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    }

    function createEducationItem(data) {
        const div = document.createElement('div');
        div.className = 'education-item';
        div.innerHTML = `
            <div class="education-header">
                <div class="education-info">
                    <h3>${data.level}</h3>
                    <p class="institution">${data.institution}</p>
                    <p class="major">${data.major}</p>
                </div>
                <div class="education-actions">
                    <button class="edit-btn"><i class="fas fa-edit"></i></button>
                    <button class="delete-btn"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            <div class="education-details">
                <p class="gpa"><i class="fas fa-star"></i> GPA: ${data.gpa}</p>
            </div>
        `;
        return div;
    }

    function createWorkItem(data) {
        const div = document.createElement('div');
        div.className = 'experience-item';
        div.innerHTML = `
            <div class="experience-header">
                <div class="experience-info">
                    <h3>${data.title}</h3>
                    <p class="company">${data.company}</p>
                    <p class="period"><i class="far fa-calendar-alt"></i> ${data.startDate} - ${data.endDate}</p>
                    <p class="location"><i class="fas fa-map-marker-alt"></i> ${data.location}</p>
                </div>
                <div class="experience-actions">
                    <button class="edit-btn"><i class="fas fa-edit"></i></button>
                    <button class="delete-btn"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            <div class="experience-details">
                ${data.description.map(desc => `<p class="description">• ${desc}</p>`).join('')}
            </div>
        `;
        return div;
    }

    function createSkillItem(data) {
        const div = document.createElement('div');
        div.className = 'skill-item';
        div.innerHTML = `
            <div class="skill-info">
                <h4>${data.skillName}</h4>
                <p class="skill-level">${data.skillLevel}</p>
            </div>
            <div class="skill-actions">
                <button class="edit-btn"><i class="fas fa-edit"></i></button>
                <button class="delete-btn"><i class="fas fa-trash"></i></button>
            </div>
        `;
        return div;
    }

    function createCertItem(data) {
        const div = document.createElement('div');
        div.className = 'cert-item';
        div.innerHTML = `
            <div class="cert-info">
                <h4>${data.certName}</h4>
                <p class="issuer">${data.issuer}</p>
                <p class="cert-date">
                    <i class="far fa-calendar-alt"></i> 
                    Issued ${formatDate(data.issueDate)}
                    ${data.noExpiry ? '' : ` · Expires ${formatDate(data.expiryDate)}`}
                </p>
                ${data.credentialId ? `
                    <p class="cert-id">
                        <i class="fas fa-certificate"></i> 
                        Credential ID: ${data.credentialId}
                    </p>
                ` : ''}
            </div>
            <div class="cert-actions">
                <button class="edit-btn"><i class="fas fa-edit"></i></button>
                <button class="delete-btn"><i class="fas fa-trash"></i></button>
            </div>
        `;
        return div;
    }

    function initializeModalHandlers(modal, formSelector, createItemFn) {
        const form = modal.querySelector(formSelector);
        const closeBtn = modal.querySelector('.close-modal');
        const cancelBtn = modal.querySelector('.cancel-btn');

        const closeModal = () => {
            modal.classList.remove('active');
            form.reset();
        };

        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            const listClass = formSelector === '.skill-form' ? '.skills-list' : '.certifications-list';
            const list = document.querySelector(listClass);
            const newItem = createItemFn(data);
            list.appendChild(newItem);
            
            closeModal();
        });
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function getDocumentTitle(type) {
        const titles = {
            cv: 'Curriculum Vitae (CV)',
            certificate: 'Certificate/Ijazah',
            portfolio: 'Portfolio'
        };
        return titles[type];
    }

    function getDocumentDescription(type) {
        const descriptions = {
            cv: 'Upload your latest CV in PDF format (Max. 2MB)',
            certificate: 'Upload your latest education certificate (Max. 2MB)',
            portfolio: 'Upload your portfolio in PDF format (Max. 5MB)'
        };
        return descriptions[type];
    }
}); 