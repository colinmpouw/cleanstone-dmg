const closedEye=`
<path d="M7.15527 3.38408C8.7082 3.19901 10.279 3.52729 11.6279 4.31877C12.9767 5.11026 14.0294 6.32146 14.6253 7.76741C14.6808 7.91709 14.6808 8.08173 14.6253 8.23141C14.3803 8.82541 14.0565 9.38375 13.6626 9.89141" stroke="#B89C82" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M9.38942 9.4386C9.01222 9.80291 8.50702 10.0045 7.98262 9.99994C7.45823 9.99539 6.9566 9.78505 6.58579 9.41423C6.21497 9.04342 6.00463 8.54179 6.00008 8.0174C5.99552 7.493 6.19711 6.9878 6.56142 6.6106" stroke="#B89C82" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M11.6527 11.666C10.7683 12.1899 9.78165 12.5174 8.75959 12.6263C7.73752 12.7352 6.70398 12.623 5.7291 12.2973C4.75422 11.9716 3.86081 11.4399 3.10949 10.7385C2.35816 10.0371 1.76651 9.18226 1.37468 8.23202C1.31912 8.08235 1.31912 7.9177 1.37468 7.76802C1.96577 6.33459 3.00579 5.13152 4.33868 4.33936" stroke="#B89C82" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M1.3335 1.33325L14.6668 14.6666" stroke="#B89C82" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
`
const openEye = `
           <g clip-path="url(#clip0_543_49)">
                                <path d="M1.37468 7.768C1.31912 7.91767 1.31912 8.08232 1.37468 8.232C1.91581 9.54409 2.83435 10.666 4.01386 11.4554C5.19336 12.2448 6.58071 12.6663 8.00001 12.6663C9.41932 12.6663 10.8067 12.2448 11.9862 11.4554C13.1657 10.666 14.0842 9.54409 14.6253 8.232C14.6809 8.08232 14.6809 7.91767 14.6253 7.768C14.0842 6.4559 13.1657 5.33402 11.9862 4.5446C10.8067 3.75517 9.41932 3.33374 8.00001 3.33374C6.58071 3.33374 5.19336 3.75517 4.01386 4.5446C2.83435 5.33402 1.91581 6.4559 1.37468 7.768Z" stroke="#B89C82" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10Z" stroke="#B89C82" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_543_49">
                                    <rect width="16" height="16" fill="white"/>
                                </clipPath>
                            </defs>
    `

function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('pw-icon');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.className = isHidden ? icon.innerHTML=closedEye : icon.innerHTML=openEye;
}