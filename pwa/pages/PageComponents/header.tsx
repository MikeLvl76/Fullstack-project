import React from "react";
import Link from "next/link";

export default function Header() {
    return (
        <>
            <nav>
                <div>
                    <div>
                        <Link href="/">Accueil</Link>
                    </div>
                    <div>
                        <Link href="/graphs">Graphiques</Link>
                    </div>
                </div>
            </nav>
        </>
    )
};