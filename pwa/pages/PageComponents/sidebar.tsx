import React, { useEffect, useState } from "react";
import { ReactDOM } from "react";
import icon from '../../public/profile.png';
import Image from 'next/image';

export default function SideBar() {

    useEffect(() => {
        const arrow: any = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e: any) => {
                const arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }
        const sidebar: any = document.querySelector(".sidebar");
        const home: any = document.querySelector(".home-section");
        const sidebarBtn: any = document.querySelector(".toggle");
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            home.classList.toggle("close");
        });
    });

    return (
        <>
            <nav>
                <div className="sidebar">
                    <div className="logo-details">
                        <i className="fa-solid fa-code"></i>
                        <span className="logo-name">FullStack Lab</span>
                    </div>
                    <i className="fa-solid fa-chevron-right toggle"></i>
                    <ul className="nav-links">
                        <li>
                            <a href="/">
                                <i className="fa-solid fa-house"></i>
                                <span className="link-name">Accueil</span>
                            </a>
                            <ul className="sub-menu blank">
                                <li><a className="link-name" href="/">Accueil</a></li>
                            </ul>
                        </li>
                        <li>
                            <div className="icon-link">
                                <a href="/graphs">
                                    <i className="fa-solid fa-chart-area"></i>
                                    <span className="link-name">Graphiques</span>
                                </a>
                                <i className="fa-solid fa-chevron-down arrow"></i>
                            </div>
                            <ul className="sub-menu">
                                <li><a className="link-name" href="/graphs">Graphiques</a></li>
                                <li><a href="/graphs">Série temporelle</a></li>
                                <li><a href="/graphs">Diagramme à barre</a></li>
                                <li><a href="/graphs">Diagramme circulaire</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i className="fa-solid fa-users"></i>
                                <span className="link-name">Notre équipe</span>
                            </a>
                            <ul className="sub-menu blank">
                                <li><a className="link-name" href="#">Notre équipe</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i className="fa-regular fa-file-lines"></i>
                                <span className="link-name">Conditions d'utilisation</span>
                            </a>
                            <ul className="sub-menu blank">
                                <li><a className="link-name" href="#">Conditions d'utilisation</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i className="fa-solid fa-shield-halved"></i>
                                <span className="link-name">Politique de confidentialité</span>
                            </a>
                            <ul className="sub-menu blank">
                                <li><a className="link-name" href="#">Politique de confidentialité</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i className="fa-regular fa-circle-question"></i>
                                <span className="link-name">A propos</span>
                            </a>
                            <ul className="sub-menu blank">
                                <li><a className="link-name" href="#">A propos</a></li>
                            </ul>
                        </li>
                        <li>
                            <div className="profile-details">
                                <div className="profile-content">
                                    <Image src={icon} alt="profile" style={{ borderRadius: "16px" }} />
                                </div>
                                <div className="name-job">
                                    <div className="profile-name">Clefs en Main</div>
                                    <div className="profile-job">Les agences immobilières en France</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </>
    )
};