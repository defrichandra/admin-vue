<template>
  <div class="contentIndex">
    <div class="header">
      <div class="appBar">
        <div class="leftBar">
          <p class="header-text">Write It Out</p>
        </div>
        <div class="rightBar">
          <p class="header-text">Home</p>
        </div>
        <div class="rightBar">
          <p class="header-text">About</p>
        </div>
        <div class="rightBar">
          <p class="header-text">Gallery</p>
        </div>
      </div>
      <div class="logoHeader">
        <div class="logo">
          <div class="logo-container">
            <svg viewBox="0 0 220 220" fill="none">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M114 30C75.3401 30 44 61.3401 44 100C44 138.66 75.3401 170 114 170C152.66 170 184 138.66 184 100C184 61.3401 152.66 30 114 30ZM114 130C97.4315 130 84 116.569 84 100C84 83.4314 97.4315 70 114 70C130.569 70 144 83.4315 144 100C144 116.569 130.569 130 114 130Z"
                fill="rgb(255, 255, 255)"
              ></path>
              <mask id="path-2-inside-1_2_1389" fill="white">
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M114 40C75.3401 40 44 71.3401 44 110C44 148.66 75.3401 180 114 180C152.66 180 184 148.66 184 110C184 71.3401 152.66 40 114 40ZM114 140C97.4315 140 84 126.569 84 110C84 93.4314 97.4315 80 114 80C130.569 80 144 93.4315 144 110C144 126.569 130.569 140 114 140Z"
                ></path>
              </mask>
              <path
                d="M52 110C52 75.7583 79.7584 48 114 48L114 32C70.9218 32 36 66.9218 36 110L52 110ZM114 172C79.7583 172 52 144.242 52 110L36 110C36 153.078 70.9218 188 114 188L114 172ZM176 110C176 144.242 148.242 172 114 172L114 188C157.078 188 192 153.078 192 110L176 110ZM114 48C148.242 48 176 75.7583 176 110L192 110C192 66.9218 157.078 32 114 32L114 48ZM76 110C76 130.987 93.0132 148 114 148L114 132C101.85 132 92 122.15 92 110L76 110ZM114 72C93.0132 72 76 89.0132 76 110L92 110C92 97.8497 101.85 88 114 88L114 72ZM152 110C152 89.0132 134.987 72 114 72L114 88C126.15 88 136 97.8497 136 110L152 110ZM114 148C134.987 148 152 130.987 152 110L136 110C136 122.15 126.15 132 114 132L114 148Z"
                fill="rgb(241, 250, 238)"
                mask="url(#path-2-inside-1_2_1389)"
              ></path>
            </svg>
          </div>
        </div>
        <div class="logo">
          <div class="logo-container">
            <svg viewBox="0 0 220 220" fill="none">
              <path
                d="M93.5 57.3509L143.689 86.3274C145.545 87.3991 146.689 89.3799 146.689 91.5235V149.477C146.689 151.62 145.545 153.601 143.689 154.673L93.5 183.649C91.6436 184.721 89.3564 184.721 87.5 183.649L37.3112 154.673C35.4548 153.601 34.3112 151.62 34.3112 149.476V91.5235C34.3112 89.3799 35.4548 87.3991 37.3112 86.3274L87.5 57.3509C89.3564 56.2791 91.6436 56.2791 93.5 57.3509Z"
                fill="rgb(255, 255, 255)"
                stroke="rgb(255, 255, 255)"
                stroke-width="8"
              ></path>
              <path
                d="M113 46.3509L163.622 75.5774C165.478 76.6491 166.622 78.6299 166.622 80.7735V139.227C166.622 141.37 165.478 143.351 163.622 144.423L113 173.649C111.144 174.721 108.856 174.721 107 173.649L56.3782 144.423C54.5218 143.351 53.3782 141.37 53.3782 139.226V80.7735C53.3782 78.6299 54.5218 76.6491 56.3782 75.5774L107 46.3509C108.856 45.2791 111.144 45.2791 113 46.3509Z"
                stroke="rgb(241, 250, 238)"
                stroke-width="8"
              ></path>
            </svg>
          </div>
        </div>
        <div class="logo">
          <div class="logo-container">
            <svg viewBox="0 0 220 220" fill="none">
              <path
                d="M62 110C62 145.277 88.0956 176.957 122.036 182.231C127.493 183.079 132 178.523 132 173V53C132 47.4772 127.501 42.9296 122.024 43.6404C88.0893 48.0449 62 74.727 62 110Z"
                fill="rgb(255, 255, 255)"
              ></path>
              <path
                d="M100.65 178.279C68.7698 173.325 44 143.42 44 110C44 76.9181 68.4126 51.7769 100.539 47.6072C103.272 47.2523 106 49.5241 106 53V173C106 176.512 103.264 178.685 100.65 178.279Z"
                stroke="rgb(241, 250, 238)"
                stroke-width="8"
              ></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="description">
      <div class="descriptionTitle">
        <h2 class="description-text">Journal Magic</h2>
      </div>
      <div class="descParagraph">
        <p class="description-text">
          Unleash your creativity and express your deepest thoughts with our
          fantastic journaling platform. Dive into the world of written
          self-discovery!
        </p>
      </div>
      <div class="descBtn" @click="directToLogin">
        <div class="btn-content">
          <p class="btn-text">Start Journaling Now</p>
        </div>
      </div>
    </div>

    <div class="about">
      <div class="aboutContent">
        <div class="aboutText">
          <p class="about-text">Why Journal?</p>
        </div>
        <div class="aboutLarge">
          <h2 class="about-text">
            Journaling has a powerful effect on your mental and emotional
            well-being.
          </h2>
        </div>
      </div>
    </div>

    <div class="features">
      <div class="featuresTitle">
        <h2 class="features-text">Amazing Features</h2>
      </div>
      <div class="feature-grid">
        <div class="feature">
          <div class="grid-title">
            <h2 class="grid-title">Express Freely</h2>
          </div>
          <div class="grid-desc">
            <h2 class="grid-desc">
              Our platform encourages you to pour your heart and mind onto the
              page without restrictions.
            </h2>
          </div>
        </div>
        <div class="feature">
          <div class="grid-title">
            <h2 class="grid-title">Privacy First</h2>
          </div>
          <div class="grid-desc">
            <h2 class="grid-desc">
              We prioritize your privacy, ensuring that your entries remain safe
              and secure.
            </h2>
          </div>
        </div>
        <div class="feature">
          <div class="grid-title">
            <h2 class="grid-title">Creative Inspirations</h2>
          </div>
          <div class="grid-descc">
            <h2 class="grid-desc">
              Draw inspiration from prompts, quotes, and challenges to rekindle
              your creativity.
            </h2>
          </div>
        </div>
        <div class="feature">
          <div class="grid-title">
            <h2 class="grid-title">Customization</h2>
          </div>
          <div class="grid-desc">
            <h2 class="grid-desc">
              Personalize your journal with themes, fonts, and colors to match
              your style.
            </h2>
          </div>
        </div>
        <div class="feature">
          <div class="grid-title">
            <h2 class="grid-title">Reflect and Grow</h2>
          </div>
          <div class="grid-desc">
            <h2 class="grid-desc">
              Our platform helps you keep track of your progress and emotional
              development.
            </h2>
          </div>
        </div>
        <div class="feature">
          <div class="grid-title">
            <h2 class="grid-title">Community Support</h2>
          </div>
          <div class="grid-desc">
            <h2 class="grid-desc">
              Connect with a community of journal enthusiasts for guidance,
              motivation, and connection.
            </h2>
          </div>
        </div>
      </div>
    </div>

    <div class="team"></div>

    <div class="faq"></div>

    <div class="footer"></div>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

function directToLogin() {
  router.push({ name: "Login" });
}
</script>

<style src="./Index.scss" lang="scss" scoped />