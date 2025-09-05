# 🔧 Ghid Configurare Tawk.to Profesională - Conectica-IT

## 1. Branding & Aspect Visual

### Acces Dashboard
- Mergi la [dashboard.tawk.to](https://dashboard.tawk.to/)
- Property ID: `68ba8c61b1986019272e8bdf`
- Widget ID: `1j4cb8n2t`

### Culori & Design
1. **Administration** → **Chat Widget** → **Appearance**
2. **Widget Color**: `#7866FF` (mov brandului) sau `#0E4D92` (albastru)
3. **Header Gradient**: Activează și setează:
   - Culoare 1: `#7866FF` 
   - Culoare 2: `#0E4D92`
4. **Poziție**: Bottom Right (dreapta jos)
5. **Logo/Avatar**: 
   - Încarcare logo Conectica-IT (PNG transparent)
   - Sau avatar cu text "CI"

### Agent Branding
1. **Administration** → **Agents** → **Your Profile**
2. **Display Name**: `Conectica-IT Asistent`
3. **Title/Tagline**: `Freelancer & Developer IT`
4. **Avatar**: Logo-ul companiei sau inițialele "CI"

---

## 2. Mesaje Automate & Triggers

### Welcome Message (când online)
**Path**: Property → **Messaging** → **Triggers** → **Add Trigger**

**Trigger Type**: Visitor comes online  
**Conditions**: Visitor is online  
**Message**:
```
👋 Bună! Cum te putem ajuta astăzi?
```

**Quick Replies** (butoane sugestii):
- `Am o întrebare`
- `Vreau o ofertă` 
- `Vreau să discut un proiect`
- `Am nevoie de suport tehnic`

### Proactive Trigger - Homepage
**Trigger Type**: Time on page  
**Conditions**: 
- Page URL contains `/index.php` OR Page URL ends with `/`
- Time on page > 20 seconds

**Message**:
```
Salut! Vrei să îți arăt portofoliul și pașii pentru o colaborare?
```

### Trigger - Pagina Proiecte
**Trigger Type**: Page specific  
**Conditions**: Page URL contains `/projects.php`  
**Delay**: 15 seconds

**Message**:
```
Te interesează detalii tehnice sau o ofertă pentru unul dintre proiecte?
```

---

## 3. Pre-Chat Form

### Activare
**Path**: Administration → **Chat Widget** → **Pre-Chat Form**

### Câmpuri Obligatorii
1. **Nume** (Text, Required)
2. **Email** (Email, Required)  
3. **Telefon** (Text, Optional)
4. **Subiect** (Dropdown, Required):
   - Ofertare
   - Colaborare  
   - Suport tehnic
   - Altele

### GDPR Checkbox
**Text**:
```
Sunt de acord ca datele furnizate să fie folosite pentru a răspunde solicitării mele, conform Politicii de confidențialitate.
```

---

## 4. Program & Away Messages

### Business Hours
**Path**: Property → **Messaging** → **Business Hours**
- **Luni-Vineri**: 09:00 - 18:00
- **Weekend**: Offline

### Offline Message
**Path**: Property → **Messaging** → **Away Message**

```
Mulțumim pentru mesaj! Suntem offline acum. Revenim pe email în max. 1 zi lucrătoare.

Dacă este urgent, ne poți suna la 0740 173 581 sau scrie pe WhatsApp.
```

---

## 5. Handoff spre WhatsApp

### Quick Reply WhatsApp
În conversație, adaugă quick reply:
```
📱 Vrei să continui pe WhatsApp? Răspundem mai rapid acolo.

👉 https://wa.me/40740173581?text=Salut,%20as%20dori%20o%20oferta%20Conectica-IT
```

### Automation Rule
**Path**: Property → **Messaging** → **Automations**
- **Trigger**: Keyword "whatsapp" or "urgent"
- **Action**: Send WhatsApp link

---

## 6. Răspunsuri Rapide (Shortcuts)

**Path**: Administration → **Shortcuts**

### /oferta
```
Pentru o ofertare rapidă, trimite-ne pe scurt tipul proiectului, funcții dorite și un interval de buget. În mod normal revenim cu o estimare inițială în 24–48h.
```

### /stack  
```
Tehnologii principale: PHP, MySQL, Bootstrap, JavaScript. Optional: API Flask/AI, export PDF/CSV, integrare WhatsApp/Email.
```

### /termene
```
Pentru un MVP clasic (pagini publice + admin + formulare) estimarea este 2–4 săptămâni, în funcție de complexitate și materiale.
```

### /suport
```
Oferim mentenanță lunară (backup, update, securitate, rapoarte). Putem semna și contract SLA.
```

### /contact
```
📧 Email: conectica.it.ro@gmail.com  
📱 Telefon: 0740 173 581  
🌐 Website: https://conectica-it.ro  
💬 WhatsApp: https://wa.me/40740173581
```

---

## 7. Etichete & Organizare

### Tags (Etichete)
**Path**: Property → **Messaging** → **Tags**

Creează taguri:
- `lead` - Lead nou
- `ofertare` - Cere ofertă  
- `proiect-nou` - Proiect în discuție
- `suport` - Suport tehnic
- `urgent` - Prioritate mare
- `whatsapp` - Transferat pe WhatsApp
- `callback` - Solicită apel

### Notificări
**Path**: Administration → **Notifications**

- ✅ **Desktop notifications**: ON
- ✅ **Mobile push**: ON  
- ✅ **Email alerts**: Dacă nu răspunde în 2 minute
- ✅ **Sound alerts**: ON

### Response Time Goal
- Target: < 3 minute în business hours
- Target: < 2 ore outside business hours

---

## 8. Analytics & Integrări

### Google Analytics
**Path**: Property → **Settings** → **Integrations** → **Google Analytics**

1. Activează tracking
2. Setează events:
   - `chat_started`
   - `lead_captured` 
   - `pre_chat_completed`
   - `whatsapp_redirect`

### Goals în GA4
Creează Conversions pentru:
- Pre-chat form completed
- Chat session > 2 minutes  
- WhatsApp redirect clicked

---

## 9. Testare & Validare

### Checklist Final
- [ ] Widget apare în dreapta jos
- [ ] Culorile match brandului  
- [ ] Welcome message afișat
- [ ] Pre-chat form functional
- [ ] Quick replies funcționează
- [ ] Shortcuts configurate
- [ ] Offline message setat
- [ ] WhatsApp link functional
- [ ] Notificări active
- [ ] Analytics conectat

### Test URLs
- Homepage: Trigger după 20s
- `/projects.php`: Trigger specific  
- Offline hours: Away message
- Pre-chat: Form completion

---

## 10. Maintenance

### Review Lunar
- Răspunsuri timp mediu
- Conversion rate pre-chat
- Top keywords/questions
- Update shortcuts dacă necesar

### Optimizări Continue  
- A/B test welcome messages
- Ajustare timing triggers
- Actualizare quick replies
- Review tags și organizare

---

**🎯 Obiectiv**: < 3 min response time, > 60% pre-chat completion, conversie lead > 15%
