const API_BASE = '/api/test';
let questions = [];
let currentIdx = 0;
let answers = [];
let timerInterval = null;
let timeLeft = 45 * 60;

const pageName = window.location.pathname.split('/').pop();

window.addEventListener('DOMContentLoaded', () => {
    if (pageName === '' || pageName === 'index.html') {
        initLoginPage();
    }

    if (pageName === 'dashboard.html') {
        initDashboardPage();
    }

    if (pageName === 'ujian.html') {
        initExamPage();
    }
});

function initLoginPage() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;
}

function initDashboardPage() {
    const nama = localStorage.getItem('namaPeserta');
    const jenis = localStorage.getItem('jenisUjian');
    const sekolah = localStorage.getItem('sekolah');

    if (!nama || !jenis || !sekolah) {
        window.location.href = '/index.html';
        return;
    }

    const welcomeText = document.getElementById('welcomeText');
    const examInfo = document.getElementById('examInfo');
    const startButton = document.getElementById('startTestBtn');

    if (welcomeText) {
        welcomeText.innerText = `Halo ${nama.toUpperCase()}, selamat datang di ujian ${jenis.toUpperCase()}`;
    }

    if (examInfo) {
        examInfo.innerText = `Sekolah: ${sekolah} | Jenis Ujian: ${jenis.toUpperCase()}`;
    }

    if (startButton) {
        startButton.addEventListener('click', () => {
            window.location.href = '/ujian.html';
        });
    }
}

async function initExamPage() {
    const nama = localStorage.getItem('namaPeserta');
    if (!nama) {
        window.location.href = '/index.html';
        return;
    }

    const profileSpan = document.querySelector('.user-profile span');
    if (profileSpan) {
        profileSpan.innerText = nama.toUpperCase();
    }

    await loadQuestions();
    createReviewButton();
}

async function loadQuestions() {
    try {
        const sessionToken = localStorage.getItem('sessionToken');
        if (!sessionToken) {
            throw new Error('Session token tidak ditemukan. Silakan login ulang.');
        }

        const response = await fetch(`${API_BASE}/questions`, {
            headers: {
                'X-Session-Token': sessionToken,
            }
        });
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Gagal memuat soal.');
        }

        questions = data.questions || [];
        answers = questions.map((item) => item.selected || null);
        timeLeft = data.time_left || 45 * 60;

        renderGrid();
        showQuestion();
        startTimer(timeLeft);
    } catch (error) {
        alert(error.message);
        window.location.href = '/index.html';
    }
}

function showQuestion() {
    if (!questions.length) return;

    const q = questions[currentIdx];
    const title = document.getElementById('q-number-title');
    const text = document.getElementById('question-text');
    const optionsList = document.getElementById('options-list');

    if (!q || !title || !text || !optionsList) return;

    title.innerText = `SOAL NOMOR ${currentIdx + 1}`;
    text.innerText = q.question_text;

    const optionsHtml = q.options.map((option, index) => {
        const selectedClass = answers[currentIdx] === option ? 'selected' : '';
        return `
            <div class="option ${selectedClass}" onclick="selectAnswer(${index})">
                <span class="opt-letter">${String.fromCharCode(65 + index)}</span>
                <span>${option}</span>
            </div>
        `;
    }).join('');

    optionsList.innerHTML = optionsHtml;
    updateGridUI();
}

function selectAnswer(index) {
    const q = questions[currentIdx];
    if (!q) return;

    answers[currentIdx] = q.options[index];
    saveAnswer(q.id, q.options[index]);
    showQuestion();
}

async function saveAnswer(questionId, answer) {
    try {
        const sessionToken = localStorage.getItem('sessionToken');
        if (!sessionToken) return;

        await fetch(`${API_BASE}/answer`, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Session-Token': sessionToken,
            },
            body: JSON.stringify({ question_id: questionId, answer }),
        });
    } catch (error) {
        console.warn('Gagal autosave jawaban:', error);
    }
}

function navSoal(step) {
    currentIdx += step;
    if (currentIdx < 0) currentIdx = 0;
    if (currentIdx >= questions.length) currentIdx = questions.length - 1;
    showQuestion();
}

function jumpTo(index) {
    currentIdx = index;
    showQuestion();
}

function renderGrid() {
    const grid = document.getElementById('grid-numbers');
    if (!grid) return;

    grid.innerHTML = questions.map((_, index) => `
        <div class="num-box" id="grid-n-${index}" onclick="jumpTo(${index})">${index + 1}</div>
    `).join('');
}

function updateGridUI() {
    questions.forEach((_, index) => {
        const element = document.getElementById(`grid-n-${index}`);
        if (!element) return;
        element.className = 'num-box';
        if (index === currentIdx) element.classList.add('active');
        if (answers[index] !== null) element.classList.add('done');
    });
}

function startTimer(duration) {
    const timerElement = document.getElementById('timer');
    if (!timerElement) return;

    if (timerInterval) {
        clearInterval(timerInterval);
    }

    let remaining = duration;
    timerElement.innerText = formatTime(remaining);

    timerInterval = setInterval(() => {
        remaining -= 1;
        if (remaining < 0) {
            clearInterval(timerInterval);
            timerElement.innerText = '00:00';
            submitExam();
            return;
        }
        timerElement.innerText = formatTime(remaining);
    }, 1000);
}

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${minutes < 10 ? '0' + minutes : minutes}:${secs < 10 ? '0' + secs : secs}`;
}

function changeFontSize(size) {
    const content = document.getElementById('q-content');
    if (!content) return;

    if (size === 'small') content.style.fontSize = '14px';
    if (size === 'medium') content.style.fontSize = '18px';
    if (size === 'large') content.style.fontSize = '24px';
}

function createReviewButton() {
    const footer = document.querySelector('.question-footer');
    if (!footer || document.getElementById('btn-review')) return;

    const reviewButton = document.createElement('button');
    reviewButton.id = 'btn-review';
    reviewButton.type = 'button';
    reviewButton.textContent = 'REVIEW & SUBMIT';
    reviewButton.style.background = '#27ae60';
    reviewButton.style.color = 'white';
    reviewButton.style.marginLeft = '10px';
    reviewButton.addEventListener('click', openReviewPanel);

    footer.appendChild(reviewButton);
}

function openReviewPanel() {
    const modal = document.createElement('div');
    modal.id = 'reviewModalOverlay';
    modal.innerHTML = `
        <div class="review-modal">
            <div class="review-card">
                <div class="review-header">
                    <h2>Review Jawaban</h2>
                    <button id="closeReview" class="review-close">&times;</button>
                </div>
                <div class="review-body">
                    <p>Jumlah soal: ${questions.length}</p>
                    <p>Terjawab: ${answers.filter((item) => item !== null).length}</p>
                    <div class="review-list">
                        ${questions.map((question, index) => `
                            <div class="review-item ${answers[index] !== null ? 'answered' : 'unanswered'}">
                                <span>Soal ${index + 1}</span>
                                <span>${answers[index] !== null ? 'Terjawab' : 'Belum'}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
                <div class="review-actions">
                    <button id="submitReview" class="btn-submit-review">KIRIM JAWABAN</button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    document.getElementById('closeReview').addEventListener('click', () => modal.remove());
    document.getElementById('submitReview').addEventListener('click', () => {
        modal.remove();
        submitExam();
    });
}

async function submitExam() {
    if (!questions.length) return;

    try {
        const sessionToken = localStorage.getItem('sessionToken');
        if (!sessionToken) {
            throw new Error('Session token tidak ditemukan.');
        }

        const answerPayload = questions.map((question, index) => ({
            question_id: question.id,
            answer: answers[index] || null,
        }));

        const response = await fetch(`${API_BASE}/submit`, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Session-Token': sessionToken,
            },
            body: JSON.stringify({ answers: answerPayload }),
        });
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Gagal mengirim jawaban.');
        }

        alert(`Ujian selesai. Skor: ${data.score}/${data.total_questions} (${data.percentage}%).`);
        localStorage.removeItem('jenisUjian');
        localStorage.removeItem('studentToken');
        localStorage.removeItem('sessionToken');
        window.location.href = '/dashboard.html';
    } catch (error) {
        alert(error.message);
    }
}

function openAdminModal() {
    const modal = document.getElementById('adminModal');
    if (modal) modal.style.display = 'block';
}

function closeAdminModal() {
    const modal = document.getElementById('adminModal');
    if (modal) modal.style.display = 'none';
}

const adminForm = document.getElementById('adminLoginForm');
if (adminForm) {
    adminForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const user = document.getElementById('adminUser').value;
        const pass = document.getElementById('adminPass').value;

        if (user === 'admin' && pass === 'admin123') {
            window.location.href = '/admin/dashboard';
        } else {
            alert('Username atau Password Admin Salah!');
        }
    });
}

window.addEventListener('click', function(event) {
    const modal = document.getElementById('adminModal');
    if (modal && event.target === modal) {
        modal.style.display = 'none';
    }
});
